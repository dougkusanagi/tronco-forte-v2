<?php

try {
    $pdo = new PDO('sqlite:../../database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test the fornecedores seeder specifically
    $file = __DIR__ . '/../../database/seeders/003_fornecedores_seeder.sql';
    $sql = file_get_contents($file);
    
    echo "Original SQL length: " . strlen($sql) . "\n";
    echo "First 200 chars: " . substr($sql, 0, 200) . "\n\n";
    
    // Split SQL statements by semicolon and execute each one
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    echo "Number of statements: " . count($statements) . "\n\n";
    
    foreach ($statements as $i => $statement) {
        echo "Statement $i length: " . strlen($statement) . "\n";
        echo "First 100 chars: " . substr($statement, 0, 100) . "\n";
        
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
    
    // Check final count
    $count = $pdo->query('SELECT COUNT(*) FROM fornecedores')->fetchColumn();
    echo "\nFinal fornecedores count: $count\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}