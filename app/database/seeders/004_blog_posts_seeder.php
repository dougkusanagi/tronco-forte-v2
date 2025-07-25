<?php

namespace app\database\seeders;

use app\database\Seeder;

class BlogPostsSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Guia Completo: Como Escolher a Madeira Ideal para Sua Construção',
                'slug' => 'guia-completo-escolher-madeira-ideal-construcao',
                'excerpt' => 'Descubra os critérios essenciais para selecionar a madeira perfeita para seu projeto de construção.',
                'content' => '<h2>Introdução</h2><p>A escolha da madeira adequada é fundamental para o sucesso de qualquer projeto de construção. Neste guia completo, você aprenderá os principais critérios para tomar a decisão certa.</p><h2>Tipos de Madeira</h2><p>Existem diversos tipos de madeira disponíveis no mercado, cada uma com características específicas...</p>',
                'featured_image' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=wood%20selection%20guide%20construction%20lumber%20types&image_size=landscape_16_9',
                'category_id' => 1, // Primeira categoria criada
                'author_id' => 1, // Admin
                'status' => 'published',
                'is_published' => 1,
                'featured' => 1,
                'views' => 1250,
                'reading_time' => 8,
                'meta_title' => 'Como Escolher a Madeira Ideal para Construção - Guia Completo',
                'meta_description' => 'Guia completo com dicas essenciais para escolher a madeira ideal para seu projeto de construção. Tipos, características e aplicações.',
                'tags' => json_encode(['madeira', 'construção', 'guia', 'tipos']),
                'published_at' => date('Y-m-d H:i:s', strtotime('-7 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-7 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
            ],
            [
                'title' => 'Certificação FSC: Por Que É Importante para o Meio Ambiente',
                'slug' => 'certificacao-fsc-importancia-meio-ambiente',
                'excerpt' => 'Entenda a importância da certificação FSC e como ela garante o manejo sustentável das florestas.',
                'content' => '<h2>O que é FSC?</h2><p>O Forest Stewardship Council (FSC) é uma organização internacional que promove o manejo responsável das florestas mundiais...</p><h2>Benefícios da Certificação</h2><p>A certificação FSC traz diversos benefícios tanto para o meio ambiente quanto para os consumidores...</p>',
                'featured_image' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=FSC%20certification%20sustainable%20forest%20management&image_size=landscape_16_9',
                'category_id' => 2, // Segunda categoria criada
                'author_id' => 1, // Admin
                'status' => 'published',
                'is_published' => 1,
                'featured' => 1,
                'views' => 890,
                'reading_time' => 6,
                'meta_title' => 'Certificação FSC: Importância para o Meio Ambiente',
                'meta_description' => 'Descubra a importância da certificação FSC para o manejo sustentável das florestas e preservação ambiental.',
                'tags' => json_encode(['FSC', 'sustentabilidade', 'certificação', 'meio ambiente']),
                'published_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'title' => 'Técnicas Modernas de Tratamento de Madeira para Construção',
                'slug' => 'tecnicas-modernas-tratamento-madeira-construcao',
                'excerpt' => 'Conheça as técnicas mais avançadas de tratamento de madeira que garantem durabilidade e resistência.',
                'content' => '<h2>Evolução dos Tratamentos</h2><p>As técnicas de tratamento de madeira evoluíram significativamente nas últimas décadas...</p><h2>Métodos Atuais</h2><p>Hoje em dia, utilizamos métodos como autoclave, impregnação e tratamentos químicos específicos...</p>',
                'featured_image' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=modern%20wood%20treatment%20facility%20industrial%20process&image_size=landscape_16_9',
                'category_id' => 3, // Terceira categoria criada
                'author_id' => 1, // Admin
                'status' => 'published',
                'is_published' => 1,
                'featured' => 0,
                'views' => 567,
                'reading_time' => 7,
                'meta_title' => 'Técnicas Modernas de Tratamento de Madeira',
                'meta_description' => 'Descubra as técnicas mais avançadas de tratamento de madeira para construção civil e suas vantagens.',
                'tags' => json_encode(['tratamento', 'madeira', 'técnicas', 'construção']),
                'published_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ]
        ];
        
        foreach ($posts as $post) {
            $this->insert('blog_posts', $post);
        }
    }
}