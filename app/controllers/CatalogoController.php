<?php

namespace app\controllers;

use app\utils\UrlHelper;
use app\models\Product;
use Flight;
use flight\Engine;

class CatalogoController
{
    private Engine $app;
    private Product $productModel;

    public function __construct(Engine $app)
    {
        $this->app = $app;
        $this->productModel = new Product();
    }

    /**
     * Lista todos os produtos do catálogo
     */
    public function index(): void
    {
        $request = $this->app->request();
        $filtro_categoria = $request->query->categoria ?? 'todos';
        $filtro_aplicacao = $request->query->aplicacao ?? 'todas';

        $produtos = $this->productModel->getFiltered($filtro_categoria, $filtro_aplicacao);

        $data = [
            'page_title' => 'Catálogo de Madeiras - Tronco Forte',
            'meta_description' => 'Catálogo completo de madeiras legalizadas. Pinus, eucalipto, ipê, cumaru e mais espécies com certificação de origem.',
            'produtos' => $produtos,
            'categorias' => $this->productModel->getCategorias(),
            'aplicacoes' => $this->productModel->getAplicacoes(),
            'filtro_categoria' => $filtro_categoria,
            'filtro_aplicacao' => $filtro_aplicacao
        ];

        // Set the content for the layout
        $content = $this->app->view()->fetch('catalogo/index', $data);
        $data['content'] = $content;
        $data['base_path'] = UrlHelper::url();
        $data['url_helper'] = UrlHelper::class;

        // Render with layout
        $this->app->render('layout', $data);
    }

    /**
     * Exibe detalhes de um produto específico
     */
    public function produto($id): void
    {
        // Handle both integer ID and string slug
        if (is_numeric($id)) {
            $produto = $this->productModel->getById((int)$id);
        } else {
            $produto = $this->productModel->getBySlug($id);
        }

        if (!$produto) {
            $this->app->halt(404, 'Produto não encontrado');
        }

        $data = [
            'page_title' => $produto['nome'] . ' - Tronco Forte',
            'meta_description' => $produto['descricao_completa'],
            'produto' => $produto,
            'produtos_relacionados' => $this->productModel->getRelated($produto['categoria'], $produto['id'])
        ];

        // Set the content for the layout
        $content = $this->app->view()->fetch('catalogo/produto', $data);
        $data['content'] = $content;

        // Render with layout
        $this->app->render('layout', $data);
    }

    /**
     * API para filtrar produtos
     */
    public function filtrar(): void
    {
        $request = $this->app->request();
        $categoria = $request->data->categoria ?? 'todos';
        $aplicacao = $request->data->aplicacao ?? 'todas';
        $preco_min = (float) ($request->data->preco_min ?? 0);
        $preco_max = (float) ($request->data->preco_max ?? 9999);

        $produtos = $this->productModel->getFiltered($categoria, $aplicacao, $preco_min, $preco_max);

        $this->app->json([
            'produtos' => $produtos,
            'total' => count($produtos)
        ]);
    }
}
