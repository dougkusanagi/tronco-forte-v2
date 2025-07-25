#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/database/Database.php';
require_once __DIR__ . '/app/database/Migration.php';
require_once __DIR__ . '/app/database/Seeder.php';

use app\database\Database;

function showHelp() {
    echo "\nTronco Forte Database Migration Tool\n";
    echo "====================================\n\n";
    echo "Usage: php migrate.php [command]\n\n";
    echo "Commands:\n";
    echo "  migrate    Run all pending migrations\n";
    echo "  seed       Run all seeders\n";
    echo "  fresh      Drop all tables, run migrations and seeders\n";
    echo "  help       Show this help message\n\n";
}

function runMigrations() {
    echo "Running migrations...\n";
    try {
        $db = Database::getInstance();
        $db->runMigrations();
        echo "Migrations completed successfully!\n";
    } catch (Exception $e) {
        echo "Error running migrations: " . $e->getMessage() . "\n";
        exit(1);
    }
}

function runSeeders() {
    echo "Running seeders...\n";
    try {
        $db = Database::getInstance();
        $db->runSeeders();
        echo "Seeders completed successfully!\n";
    } catch (Exception $e) {
        echo "Error running seeders: " . $e->getMessage() . "\n";
        exit(1);
    }
}

function freshDatabase() {
    echo "Refreshing database...\n";
    
    try {
        // Get database configuration
        $config = require __DIR__ . '/app/config/config.php';
        $dbName = $config['database']['dbname'];
        
        // Connect to MySQL server (without specifying database)
        $dsn = "mysql:host={$config['database']['host']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['database']['user'], $config['database']['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if database exists
        $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
        $stmt->execute([$dbName]);
        $dbExists = $stmt->fetch() !== false;
        
        if ($dbExists) {
            // Prompt user for confirmation
            echo "Database '{$dbName}' already exists. Do you want to recreate it? [Y/n]: ";
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            fclose($handle);
            
            $response = trim(strtolower($line));
            if ($response === '' || $response === 'y' || $response === 'yes') {
                // Drop and recreate database
                $pdo->exec("DROP DATABASE `{$dbName}`");
                $pdo->exec("CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                echo "Existing database dropped and recreated.\n";
            } else {
                echo "Operation cancelled.\n";
                exit(0);
            }
        } else {
            // Create new database
            echo "Database '{$dbName}' does not exist. Creating new database...\n";
            $pdo->exec("CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "New database created.\n";
        }
        
    } catch (Exception $e) {
        echo "Error managing database: " . $e->getMessage() . "\n";
        exit(1);
    }
    
    runMigrations();
    runSeeders();
    
    echo "Database refreshed successfully!\n";
}

// Get command from arguments
$command = $argv[1] ?? 'help';

switch ($command) {
    case 'migrate':
        runMigrations();
        break;
        
    case 'seed':
        runSeeders();
        break;
        
    case 'fresh':
        freshDatabase();
        break;
        
    case 'help':
    default:
        showHelp();
        break;
}