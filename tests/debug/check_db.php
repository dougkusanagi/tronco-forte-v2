<?php
try {
    $pdo = new PDO('sqlite:../../database.sqlite');
    $tables = $pdo->query('SELECT name FROM sqlite_master WHERE type="table"')->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables in database:\n";
    print_r($tables);
    
    // Check if we have data in key tables
    if (in_array('fornecedores', $tables)) {
        $count = $pdo->query('SELECT COUNT(*) FROM fornecedores')->fetchColumn();
        echo "\nFornecedores count: $count\n";
    }
    
    if (in_array('blog_posts', $tables)) {
        $count = $pdo->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
        echo "Blog posts count: $count\n";
    }
    
    if (in_array('blog_categories', $tables)) {
        $count = $pdo->query('SELECT COUNT(*) FROM blog_categories')->fetchColumn();
        echo "Blog categories count: $count\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>