<?php

require_once '../../app/config/bootstrap.php';

try {
    $db = Flight::db();
    
    // Verificar total de posts
    $stmt = $db->query('SELECT COUNT(*) as total FROM blog_posts');
    $result = $stmt->fetch();
    echo "Total de posts: " . $result['total'] . PHP_EOL;
    
    // Verificar posts existentes
    $stmt = $db->query('SELECT id, title, status, created_at FROM blog_posts LIMIT 10');
    $posts = $stmt->fetchAll();
    
    echo "\nPosts encontrados:\n";
    foreach($posts as $post) {
        echo "ID: {$post['id']}, Title: {$post['title']}, Status: {$post['status']}, Created: {$post['created_at']}\n";
    }
    
    // Verificar posts publicados
    $stmt = $db->query("SELECT COUNT(*) as total FROM blog_posts WHERE status = 'published'");
    $result = $stmt->fetch();
    echo "\nTotal de posts publicados: " . $result['total'] . PHP_EOL;
    
    // Verificar estrutura da tabela
    $stmt = $db->query('PRAGMA table_info(blog_posts)');
    $columns = $stmt->fetchAll();
    
    echo "\nEstrutura da tabela blog_posts:\n";
    foreach($columns as $column) {
        echo "- {$column['name']} ({$column['type']})\n";
    }
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . PHP_EOL;
}