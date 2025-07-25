<?php

namespace app\database\seeders;

use app\database\Seeder;

class BlogCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Técnicas de Construção',
                'slug' => 'tecnicas-construcao',
                'description' => 'Artigos sobre técnicas e métodos de construção com madeira',
                'color' => '#8B4513',
                'icon' => 'hammer',
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Sustentabilidade',
                'slug' => 'sustentabilidade',
                'description' => 'Conteúdo sobre práticas sustentáveis e certificações',
                'color' => '#228B22',
                'icon' => 'leaf',
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Tipos de Madeira',
                'slug' => 'tipos-madeira',
                'description' => 'Guias sobre diferentes espécies e suas aplicações',
                'color' => '#CD853F',
                'icon' => 'tree-pine',
                'active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        foreach ($categories as $category) {
            $this->insert('blog_categories', $category);
        }
    }
}