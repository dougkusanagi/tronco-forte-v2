<?php

namespace app\database;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;
    
    private function __construct()
    {
        $config = require __DIR__ . '/../config/config.php';
        
        try {
            // Use MySQL configuration
            $dsn = "mysql:host={$config['database']['host']};dbname={$config['database']['dbname']};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $config['database']['user'], $config['database']['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
    
    public function query(string $sql, array $params = []): array
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new \Exception("Query failed: " . $e->getMessage());
        }
    }
    
    public function execute(string $sql, array $params = []): bool
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw new \Exception("Execute failed: " . $e->getMessage());
        }
    }
    
    public function runMigrations(): void
    {
        // Create migrations table if it doesn't exist
        $this->createMigrationsTable();
        
        $migrationFiles = glob(__DIR__ . '/migrations/*.php');
        sort($migrationFiles);
        
        foreach ($migrationFiles as $file) {
            $migrationName = basename($file, '.php');
            
            if (!$this->migrationExists($migrationName)) {
                $className = $this->getMigrationClassName($migrationName);
                
                try {
                    require_once $file;
                    
                    if (class_exists($className)) {
                        $migration = new $className($this->pdo);
                        $migration->up();
                        
                        $this->recordMigration($migrationName);
                        echo "Migrated: {$migrationName}\n";
                    } else {
                        throw new \Exception("Migration class not found: {$className}");
                    }
                } catch (\Exception $e) {
                    throw new \Exception("Migration failed ({$migrationName}): " . $e->getMessage());
                }
            }
        }
    }
    
    public function runSeeders(): void
    {
        $seederFiles = glob(__DIR__ . '/seeders/*.php');
        sort($seederFiles);
        
        foreach ($seederFiles as $file) {
            $seederName = basename($file, '.php');
            $className = $this->getSeederClassName($seederName);
            
            try {
                require_once $file;
                
                if (class_exists($className)) {
                    $seeder = new $className($this->pdo);
                    $seeder->run();
                    echo "Seeded: {$seederName}\n";
                } else {
                    echo "Seeder class not found: {$className}\n";
                }
            } catch (\Exception $e) {
                echo "Seeder failed ({$seederName}): " . $e->getMessage() . "\n";
                // Continue with other seeders instead of throwing exception
            }
        }
    }
    
    private function createMigrationsTable(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";
        
        $this->pdo->exec($sql);
    }
    
    private function migrationExists(string $migrationName): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
        $stmt->execute([$migrationName]);
        return $stmt->fetchColumn() > 0;
    }
    
    private function recordMigration(string $migrationName): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$migrationName]);
    }
    
    private function getMigrationClassName(string $migrationName): string
    {
        // Remove the numeric prefix (e.g., "001_") and convert to PascalCase
        $parts = explode('_', $migrationName);
        $className = '';
        
        foreach ($parts as $part) {
            if (is_numeric($part)) continue; // Skip numeric parts
            $className .= ucfirst($part);
        }
        
        return "app\\database\\migrations\\{$className}";
    }
    
    private function getSeederClassName(string $seederName): string
    {
        // Convert snake_case to PascalCase
        $parts = explode('_', $seederName);
        $className = '';
        
        foreach ($parts as $part) {
            if (is_numeric($part)) continue; // Skip numeric parts
            $className .= ucfirst($part);
        }
        
        return "app\\database\\seeders\\{$className}";
    }
}