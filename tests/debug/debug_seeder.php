<?php

require_once __DIR__ . '/../../app/database/Database.php';
use app\database\Database;

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    
    // Test the fornecedores seeder specifically
    $file = __DIR__ . '/../../database/seeders/003_fornecedores_seeder.sql';
    $sql = file_get_contents($file);
    
    echo "Original SQL:\n";
    echo $sql . "\n\n";
    
    // Split SQL statements by semicolon and execute each one
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    echo "Split statements:\n";
    foreach ($statements as $i => $statement) {
        echo "Statement $i:\n";
        echo $statement . "\n\n";
        
        if (!empty($statement) && !preg_match('/^\s*--/', $statement)) {
            echo "Executing statement $i...\n";
            try {
                $result = $pdo->exec($statement);
                echo "Rows affected: $result\n";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage() . "\n";
            }
        } else {
            echo "Skipping statement $i (empty or comment)\n";
        }
        echo "---\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}