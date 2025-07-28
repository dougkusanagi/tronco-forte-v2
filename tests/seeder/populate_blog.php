<?php

require_once '../../vendor/autoload.php';
require_once '../../app/config/bootstrap.php';

// Get database connection
$db = Flight::db();

// Clear existing data
$db->exec("DELETE FROM blog_categories");
$db->exec("DELETE FROM blog_posts");

// Insert blog categories
$categories = [
    [
        'name' => 'Sustentabilidade',
        'slug' => 'sustentabilidade',
        'description' => 'Artigos sobre práticas sustentáveis na indústria madeireira',
        'color' => '#22c55e',
        'icon' => 'leaf',
        'active' => 1
    ],
    [
        'name' => 'Técnicas',
        'slug' => 'tecnicas',
        'description' => 'Guias e tutoriais sobre técnicas de trabalho com madeira',
        'color' => '#3b82f6',
        'icon' => 'wrench',
        'active' => 1
    ],
    [
        'name' => 'Mercado',
        'slug' => 'mercado',
        'description' => 'Análises e tendências do mercado madeireiro',
        'color' => '#f59e0b',
        'icon' => 'trending-up',
        'active' => 1
    ],
    [
        'name' => 'Inovação',
        'slug' => 'inovacao',
        'description' => 'Novidades e inovações tecnológicas no setor',
        'color' => '#8b5cf6',
        'icon' => 'lightbulb',
        'active' => 1
    ]
];

$stmt = $db->prepare("
    INSERT INTO blog_categories (name, slug, description, color, icon, active, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, datetime('now'), datetime('now'))
");

foreach ($categories as $category) {
    $stmt->execute([
        $category['name'],
        $category['slug'],
        $category['description'],
        $category['color'],
        $category['icon'],
        $category['active']
    ]);
}

// Insert blog posts
$posts = [
    [
        'title' => 'Certificação FSC: O Que Você Precisa Saber',
        'slug' => 'certificacao-fsc-guia-completo',
        'excerpt' => 'Entenda a importância da certificação FSC e como ela garante a sustentabilidade na cadeia produtiva da madeira.',
        'content' => '<p>A certificação FSC (Forest Stewardship Council) é um dos principais selos de sustentabilidade no setor madeireiro...</p>',
        'featured_image' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=FSC%20certification%20sustainable%20forest%20management%20logo&image_size=landscape_16_9',
        'category_id' => 1,
        'author_id' => 1,
        'status' => 'published',
        'featured' => 1,
        'views' => 1250,
        'reading_time' => 8,
        'meta_title' => 'Certificação FSC: Guia Completo para Sustentabilidade',
        'meta_description' => 'Descubra tudo sobre a certificação FSC e sua importância para a sustentabilidade na indústria madeireira.',
        'tags' => json_encode(['FSC', 'Sustentabilidade', 'Certificação', 'Meio Ambiente']),
        'published_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
    ],
    [
        'title' => 'Técnicas de Secagem da Madeira: Métodos e Benefícios',
        'slug' => 'tecnicas-secagem-madeira',
        'excerpt' => 'Conheça os principais métodos de secagem da madeira e como escolher a técnica ideal para cada tipo de projeto.',
        'content' => '<p>A secagem adequada da madeira é fundamental para garantir a qualidade e durabilidade dos produtos...</p>',
        'featured_image' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=wood%20drying%20kiln%20lumber%20processing%20industrial&image_size=landscape_16_9',
        'category_id' => 2,
        'author_id' => 2,
        'status' => 'published',
        'featured' => 1,
        'views' => 890,
        'reading_time' => 6,
        'meta_title' => 'Técnicas de Secagem da Madeira: Guia Prático',
        'meta_description' => 'Aprenda sobre os métodos de secagem da madeira e como aplicá-los corretamente.',
        'tags' => json_encode(['Secagem', 'Técnicas', 'Processamento', 'Qualidade']),
        'published_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
    ],
    [
        'title' => 'Mercado de Madeira 2024: Tendências e Perspectivas',
        'slug' => 'mercado-madeira-2024-tendencias',
        'excerpt' => 'Análise completa das tendências do mercado madeireiro brasileiro e perspectivas para o próximo ano.',
        'content' => '<p>O mercado madeireiro brasileiro apresenta sinais de recuperação e crescimento sustentável...</p>',
        'featured_image' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=lumber%20market%20trends%20charts%20business%20analysis&image_size=landscape_16_9',
        'category_id' => 3,
        'author_id' => 1,
        'status' => 'published',
        'featured' => 0,
        'views' => 567,
        'reading_time' => 10,
        'meta_title' => 'Mercado de Madeira 2024: Análise e Tendências',
        'meta_description' => 'Confira as principais tendências e perspectivas do mercado madeireiro para 2024.',
        'tags' => json_encode(['Mercado', 'Tendências', '2024', 'Análise', 'Economia']),
        'published_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
    ],
    [
        'title' => 'Inovações em Tratamento de Madeira: Tecnologias Emergentes',
        'slug' => 'inovacoes-tratamento-madeira',
        'excerpt' => 'Descubra as mais recentes inovações tecnológicas no tratamento e preservação da madeira.',
        'content' => '<p>As novas tecnologias de tratamento da madeira estão revolucionando a indústria...</p>',
        'featured_image' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=wood%20treatment%20technology%20innovation%20laboratory&image_size=landscape_16_9',
        'category_id' => 4,
        'author_id' => 2,
        'status' => 'published',
        'featured' => 1,
        'views' => 723,
        'reading_time' => 7,
        'meta_title' => 'Inovações em Tratamento de Madeira: Guia 2024',
        'meta_description' => 'Conheça as tecnologias emergentes no tratamento e preservação da madeira.',
        'tags' => json_encode(['Inovação', 'Tratamento', 'Tecnologia', 'Preservação']),
        'published_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
    ]
];

$stmt = $db->prepare("
    INSERT INTO blog_posts (
        title, slug, excerpt, content, featured_image, category_id, author_id, status, featured,
        views, reading_time, meta_title, meta_description, tags, published_at, created_at, updated_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, datetime('now'), datetime('now')
    )
");

foreach ($posts as $post) {
    $stmt->execute([
        $post['title'],
        $post['slug'],
        $post['excerpt'],
        $post['content'],
        $post['featured_image'],
        $post['category_id'],
        $post['author_id'],
        $post['status'],
        $post['featured'],
        $post['views'],
        $post['reading_time'],
        $post['meta_title'],
        $post['meta_description'],
        $post['tags'],
        $post['published_at']
    ]);
}

echo "Blog data inserted successfully!\n";
echo "Categories: " . count($categories) . "\n";
echo "Posts: " . count($posts) . "\n";