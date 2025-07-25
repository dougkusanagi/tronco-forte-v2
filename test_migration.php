<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/database/Database.php';

use app\database\Database;

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    
    echo "Testing direct SQL execution...\n";
    
    // Read the migration file
    $sql = file_get_contents(__DIR__ . '/database/migrations/001_create_users_table.sql');
    echo "SQL content:\n" . $sql . "\n\n";
    
    // Split and execute statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    foreach ($statements as $i => $statement) {
        if (!empty($statement) && !preg_match('/^\s*--/', $statement)) {
            echo "Executing statement " . ($i + 1) . ":\n";
            echo $statement . "\n";
            
            try {
                $pdo->exec($statement);
                echo "✓ Success\n\n";
            } catch (Exception $e) {
                echo "✗ Error: " . $e->getMessage() . "\n\n";
            }
        }
    }
    
    // Check if table was created
    $result = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
    if ($result->fetch()) {
        echo "✓ Users table created successfully\n";
    } else {
        echo "✗ Users table not found\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}