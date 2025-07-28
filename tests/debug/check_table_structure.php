<?php

try {
    $pdo = new PDO('sqlite:../../database.sqlite');
    
    echo "Blog Categories table structure:\n";
    $result = $pdo->query('PRAGMA table_info(blog_categories)');
    while ($row = $result->fetch()) {
        echo "- {$row['name']} ({$row['type']})\n";
    }
    
    echo "\nFornecedores table structure:\n";
    $result = $pdo->query('PRAGMA table_info(fornecedores)');
    while ($row = $result->fetch()) {
        echo "- {$row['name']} ({$row['type']})\n";
    }
    
    echo "\nBlog Posts table structure:\n";
    $result = $pdo->query('PRAGMA table_info(blog_posts)');
    while ($row = $result->fetch()) {
        echo "- {$row['name']} ({$row['type']})\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}