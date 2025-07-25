<?php

declare(strict_types=1);

namespace app\commands;

use flight\commands\AbstractBaseCommand;
use app\database\Database;

class MigrateCommand extends AbstractBaseCommand
{
    /**
     * Construct
     *
     * @param array<string,mixed> $config JSON config from .runway-config.json
     */
    public function __construct(array $config)
    {
        parent::__construct('migrate', 'Database migration commands', $config);
        
        // Add argument for action
        $this->argument('<action>', 'Action to perform: migrate, seed, fresh');
    }

    /**
     * Executes the function
     *
     * @return void
     */
    public function execute()
    {
        $io = $this->app()->io();
        $action = $this->values()['action'] ?? 'migrate';
        
        $io->info("MigrateCommand execute called with action: $action");
        
        switch ($action) {
            case 'migrate':
                $this->runMigrations($io);
                break;
                
            case 'seed':
                $this->runSeeders($io);
                break;
                
            case 'fresh':
                $this->freshDatabase($io);
                break;
                
            default:
                $io->error("Unknown action: $action");
                $io->info('Available actions: migrate, seed, fresh');
                break;
        }
    }

    /**
     * Run database migrations
     */
    private function runMigrations($io)
    {
        try {
            $io->info('Running migrations...');
            
            // Get database configuration
            $configPath = __DIR__ . '/../config/config.php';
            if (!file_exists($configPath)) {
                throw new \Exception('Config file not found at: ' . $configPath);
            }
            
            $config = require $configPath;
            if (!is_array($config) || !isset($config['database'])) {
                throw new \Exception('Invalid config format or missing database configuration');
            }
            
            $dbConfig = $config['database'];
            
            // Debug: Show configuration
            $io->info('Database config: ' . json_encode($dbConfig));
            
            // Check if using SQLite
            $isUsingSQLite = isset($dbConfig['file_path']);
            $io->info('Using SQLite: ' . ($isUsingSQLite ? 'Yes' : 'No'));
            
            if ($isUsingSQLite) {
                 $this->runSQLiteMigrations($io, $dbConfig);
             } else {
                 $db = Database::getInstance();
                 $db->runMigrations();
             }
            
            $io->ok('Migrations completed successfully!');
        } catch (\Exception $e) {
            $io->error('Error running migrations: ' . $e->getMessage());
        }
    }

    /**
     * Run database seeders
     */
    private function runSeeders($io)
    {
        try {
            $io->info('Running seeders...');
            
            // Get database configuration
            $configPath = __DIR__ . '/../config/config.php';
            $config = require $configPath;
            $dbConfig = $config['database'];
            
            // Check if using SQLite
            if (isset($dbConfig['file_path'])) {
                $this->runSQLiteSeeders($io, $dbConfig);
            } else {
                $db = Database::getInstance();
                $db->runSeeders();
            }
            
            $io->ok('Seeders completed successfully!');
        } catch (\Exception $e) {
            $io->error('Error running seeders: ' . $e->getMessage());
        }
    }

    /**
     * Fresh database (drop and recreate)
     */
    private function freshDatabase($io)
    {
        try {
            // Get database configuration
            $config = require __DIR__ . '/../config/config.php';
            $dbConfig = $config['database'];
            
            // Check if using SQLite
            if (isset($dbConfig['file_path'])) {
                $dbFile = $dbConfig['file_path'];
                
                if (file_exists($dbFile)) {
                    $io->info("This will delete the existing SQLite database at: $dbFile");
                    $response = $io->prompt('Continue? (y/N)', 'n');
                    
                    if (strtolower($response) === 'y') {
                        unlink($dbFile);
                        $io->info('SQLite database file deleted.');
                    } else {
                        $io->info('Operation cancelled.');
                        return;
                    }
                }
            } else {
                 $io->info('Recreating database...');
                 // For MySQL, we'll handle database recreation manually
                 $this->recreateMySQLDatabase($io, $dbConfig);
             }
            
            $io->info('Running migrations...');
            if (isset($dbConfig['file_path'])) {
                 $this->runSQLiteMigrations($io, $dbConfig);
             } else {
                 $db = Database::getInstance();
                 $db->runMigrations();
             }
            
            $io->info('Running seeders...');
            if (isset($dbConfig['file_path'])) {
                $this->runSQLiteSeeders($io, $dbConfig);
            } else {
                $db = Database::getInstance();
                $db->runSeeders();
            }
            
            $io->ok('Fresh database setup completed!');
        } catch (\Exception $e) {
            $io->error('Error setting up fresh database: ' . $e->getMessage());
        }
    }
    
    /**
     * Run SQLite-compatible migrations
     */
    private function runSQLiteMigrations($io, array $dbConfig)
    {
        $pdo = new \PDO('sqlite:' . $dbConfig['file_path']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
        // Enable foreign keys and WAL mode for better performance
        $pdo->exec('PRAGMA foreign_keys = ON');
        $pdo->exec('PRAGMA journal_mode = WAL');
        
        // Use SQLite-specific migrations if available, otherwise convert MySQL migrations
        $sqliteMigrationsDir = __DIR__ . '/../../database/sqlite_migrations';
        $mysqlMigrationsDir = __DIR__ . '/../../database/migrations';
        
        $migrationsDir = is_dir($sqliteMigrationsDir) ? $sqliteMigrationsDir : $mysqlMigrationsDir;
        $usingSQLiteSpecific = ($migrationsDir === $sqliteMigrationsDir);
        
        $migrationFiles = glob($migrationsDir . '/*.sql');
        sort($migrationFiles);
        
        $io->info("Found " . count($migrationFiles) . " migration files in " . ($usingSQLiteSpecific ? 'SQLite-specific' : 'MySQL') . " directory");
        
        foreach ($migrationFiles as $file) {
            $filename = basename($file);
            $io->info("Running migration: $filename");
            
            $sql = file_get_contents($file);
            
            if ($usingSQLiteSpecific) {
                // Use SQLite migrations as-is
                $finalSql = $sql;
                $io->info("Using SQLite-specific migration");
            } else {
                // Convert MySQL syntax to SQLite
                $finalSql = $this->convertMySQLToSQLite($sql);
                $io->info("Converted MySQL to SQLite syntax");
            }
            
            try {
                // Begin transaction
                $pdo->beginTransaction();
                
                // Execute the entire SQL as one statement for SQLite
                $pdo->exec($finalSql);
                
                // Commit transaction
                $pdo->commit();
                $io->ok("Migration $filename completed");
            } catch (\Exception $e) {
                $pdo->rollBack();
                throw new \Exception("Migration failed ($filename): " . $e->getMessage());
            }
        }
    }
    
    /**
     * Convert MySQL syntax to SQLite
     */
    private function convertMySQLToSQLite(string $sql): string
    {
        // Handle AUTO_INCREMENT with PRIMARY KEY
        $sql = preg_replace('/INT\s+AUTO_INCREMENT\s+PRIMARY\s+KEY/i', 'INTEGER PRIMARY KEY AUTOINCREMENT', $sql);
        
        // Handle standalone AUTO_INCREMENT
        $sql = preg_replace('/INT\s+AUTO_INCREMENT/i', 'INTEGER', $sql);
        
        // Replace VARCHAR with TEXT
        $sql = preg_replace('/VARCHAR\(\d+\)/i', 'TEXT', $sql);
        
        // Replace TINYINT(1) with INTEGER
        $sql = preg_replace('/TINYINT\(1\)/i', 'INTEGER', $sql);
        
        // Replace ENUM with TEXT (SQLite doesn't support ENUM)
        $sql = preg_replace('/ENUM\([^)]+\)/i', 'TEXT', $sql);
        
        // Replace TIMESTAMP with TEXT (SQLite stores dates as text)
        $sql = preg_replace('/TIMESTAMP/i', 'TEXT', $sql);
        
        // Remove ON UPDATE CURRENT_TIMESTAMP (not supported in SQLite)
        $sql = preg_replace('/ON UPDATE CURRENT_TIMESTAMP/i', '', $sql);
        
        // Replace CURRENT_TIMESTAMP with datetime('now')
        $sql = preg_replace('/DEFAULT CURRENT_TIMESTAMP/i', "DEFAULT (datetime('now'))", $sql);
        
        // Handle CREATE INDEX IF NOT EXISTS - SQLite supports this
        // No change needed for this
        
        // Clean up extra whitespace
        $sql = preg_replace('/\s+/', ' ', $sql);
        $sql = preg_replace('/,\s*,/', ',', $sql);
        
        return $sql;
     }
     
     /**
      * Run SQLite-compatible seeders
      */
     private function runSQLiteSeeders($io, array $dbConfig)
     {
         $pdo = new \PDO('sqlite:' . $dbConfig['file_path']);
         $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
         
         // Enable foreign keys
         $pdo->exec('PRAGMA foreign_keys = ON');
         
         // Use SQLite-specific seeders if available, otherwise convert MySQL seeders
         $sqliteSeedersDir = __DIR__ . '/../../database/sqlite_seeders';
         $mysqlSeedersDir = __DIR__ . '/../../database/seeders';
         
         $seedersDir = is_dir($sqliteSeedersDir) ? $sqliteSeedersDir : $mysqlSeedersDir;
         $usingSQLiteSpecific = ($seedersDir === $sqliteSeedersDir);
         
         $seederFiles = glob($seedersDir . '/*.sql');
         sort($seederFiles);
         
         $io->info("Found " . count($seederFiles) . " seeder files in " . ($usingSQLiteSpecific ? 'SQLite-specific' : 'MySQL') . " directory");
         
         foreach ($seederFiles as $file) {
             $filename = basename($file);
             $io->info("Running seeder: $filename");
             
             $sql = file_get_contents($file);
             
             if ($usingSQLiteSpecific) {
                 // Use SQLite seeders as-is
                 $finalSql = $sql;
                 $io->info("Using SQLite-specific seeder");
             } else {
                 // Convert MySQL syntax to SQLite
                 $finalSql = $this->convertMySQLToSQLite($sql);
                 $io->info("Converted MySQL to SQLite syntax");
             }
             
             try {
                 // Begin transaction
                 $pdo->beginTransaction();
                 
                 // Execute the entire SQL as one statement for SQLite
                  $pdo->exec($finalSql);
                 
                 // Commit transaction
                 $pdo->commit();
                 $io->ok("Seeder $filename completed");
             } catch (\Exception $e) {
                 $pdo->rollBack();
                 throw new \Exception("Seeder failed ($filename): " . $e->getMessage());
             }
         }
     }
     
     /**
      * Recreate MySQL database
      */
     private function recreateMySQLDatabase($io, array $dbConfig)
     {
         $dbName = $dbConfig['dbname'];
         $dsn = "mysql:host={$dbConfig['host']};charset=utf8mb4";
         $pdo = new \PDO($dsn, $dbConfig['user'], $dbConfig['password']);
         $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
         
         // Check if database exists
         $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
         $stmt->execute([$dbName]);
         $dbExists = $stmt->fetch() !== false;
         
         if ($dbExists) {
             $io->info("Database '$dbName' already exists. This will recreate it.");
             $response = $io->prompt('Continue? (y/N)', 'n');
             
             if (strtolower($response) === 'y') {
                 $pdo->exec("DROP DATABASE `{$dbName}`");
                 $pdo->exec("CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                 $io->ok('Database recreated successfully.');
             } else {
                 $io->info('Operation cancelled.');
                 throw new \Exception('Database recreation cancelled by user.');
             }
         } else {
             $io->info("Database '$dbName' does not exist. Creating new database...");
             $pdo->exec("CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
             $io->ok('New database created.');
         }
     }
}