<?php

try {
    $pdo = new PDO('sqlite:../../database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test blog categories insert
    $sql = "INSERT OR REPLACE INTO blog_categories (name, slug, description, color, is_active) VALUES ('Test Category', 'test-category', 'Test description', '#FF0000', 1)";
    
    echo "Executing: $sql\n";
    $result = $pdo->exec($sql);
    echo "Rows affected: $result\n";
    
    // Check count
    $count = $pdo->query('SELECT COUNT(*) FROM blog_categories')->fetchColumn();
    echo "Blog categories count: $count\n";
    
    // Test fornecedores insert
    $sql2 = "INSERT OR REPLACE INTO fornecedores (nome, slug, is_ativo) VALUES ('Test Fornecedor', 'test-fornecedor', 1)";
    echo "\nExecuting: $sql2\n";
    $result2 = $pdo->exec($sql2);
    echo "Rows affected: $result2\n";
    
    // Check count
    $count2 = $pdo->query('SELECT COUNT(*) FROM fornecedores')->fetchColumn();
    echo "Fornecedores count: $count2\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}