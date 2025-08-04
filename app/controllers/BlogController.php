<?php

namespace app\controllers;

use flight\Engine;
use app\models\BlogPost;
use app\models\BlogCategory;
use app\utils\UrlHelper;

class BlogController
{
    private Engine $app;
    private $blogPostModel;
    private $blogCategoryModel;

    public function __construct(Engine $app)
    {
        $this->app = $app;
        $this->blogPostModel = new BlogPost();
        $this->blogCategoryModel = new BlogCategory();
    }

    /**
     * Lista todos os artigos do blog
     */
    public function index(): void
    {
        $request = $this->app->request();
        $categoria = $request->query->categoria ?? 'todas';
        $pagina = (int) ($request->query->pagina ?? 1);
        $por_pagina = 6;

        // Obter artigos do banco de dados
        $artigos = $this->blogPostModel->getComCategoria();

        // Filtrar por categoria se especificada
        if ($categoria !== 'todas') {
            $artigos = array_filter($artigos, function ($artigo) use ($categoria) {
                return $artigo['categoria_slug'] === $categoria;
            });
        }

        // Processar dados dos artigos
        $artigos = array_map([$this->blogPostModel, 'processarDados'], $artigos);

        $total_artigos = count($artigos);
        $total_paginas = ceil($total_artigos / $por_pagina);

        $offset = ($pagina - 1) * $por_pagina;
        $artigos_pagina = array_slice($artigos, $offset, $por_pagina);

        // Obter artigos em destaque
        $artigos_destaque = $this->blogPostModel->getDestaques();
        $artigo_destaque = !empty($artigos_destaque) ? $this->blogPostModel->processarDados($artigos_destaque[0]) : null;

        // Obter categorias
        $categorias = $this->blogCategoryModel->getComContadores();

        $data = [
            'page_title' => 'Blog Técnico - Tronco Forte',
            'meta_description' => 'Artigos técnicos sobre madeira, construção e sustentabilidade. Dicas profissionais para construtores e carpinteiros.',
            'artigos' => $artigos, // Pass all articles for Alpine.js filtering
            'artigos_pagina' => $artigos_pagina, // Keep paginated articles for server-side pagination if needed
            'categorias' => $categorias,
            'categoria_atual' => $categoria,
            'pagina_atual' => $pagina,
            'total_paginas' => $total_paginas,
            'total_artigos' => $total_artigos,
            'por_pagina' => $por_pagina,
            'artigo_destaque' => $artigo_destaque
        ];

        // Set the content for the layout
        $content = $this->app->view()->fetch('blog/index', $data);
        $data['content'] = $content;
        $data['base_path'] = UrlHelper::url();
        $data['url_helper'] = UrlHelper::class;

        // Render with layout
        $this->app->render('layout', $data);
    }

    /**
     * Exibe um artigo específico
     */
    public function artigo(string $slug): void
    {
        $artigo = $this->blogPostModel->getBySlug($slug);

        if (!$artigo) {
            $this->app->halt(404, 'Artigo não encontrado');
        }

        // Processar dados do artigo
        $artigo = $this->blogPostModel->processarDados($artigo);

        // Obter artigos relacionados (mesma categoria)
        $artigos_relacionados = [];
        if (isset($artigo['categoria_id'])) {
            $relacionados = $this->blogPostModel->getByCategoria($artigo['categoria_id']);
            $artigos_relacionados = array_filter($relacionados, function ($item) use ($artigo) {
                return $item['id'] !== $artigo['id'];
            });
            $artigos_relacionados = array_slice($artigos_relacionados, 0, 3);
            $artigos_relacionados = array_map([$this->blogPostModel, 'processarDados'], $artigos_relacionados);
        }

        $data = [
            'page_title' => $artigo['titulo'] . ' - Blog Tronco Forte',
            'meta_description' => $artigo['resumo'],
            'artigo' => $artigo,
            'artigos_relacionados' => $artigos_relacionados
        ];

        // Set the content for the layout
        $content = $this->app->view()->fetch('blog/artigo', $data);
        $data['content'] = $content;
        $data['base_path'] = UrlHelper::url();
        $data['url_helper'] = UrlHelper::class;

        // Render with layout
        $this->app->render('layout', $data);
    }

    /**
     * API para buscar artigos
     */
    public function buscar(): void
    {
        $request = $this->app->request();
        $termo = $request->data->termo ?? '';
        $categoria = $request->data->categoria ?? 'todas';

        $artigos = $this->blogPostModel->search($termo);

        // Filtrar por categoria se especificada
        if ($categoria !== 'todas') {
            $artigos = array_filter($artigos, function ($artigo) use ($categoria) {
                return $artigo['categoria_slug'] === $categoria;
            });
        }

        // Processar dados dos artigos
        $artigos = array_map([$this->blogPostModel, 'processarDados'], $artigos);

        $this->app->json([
            'artigos' => $artigos,
            'total' => count($artigos)
        ]);
    }
}
