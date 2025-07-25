<?php

namespace app\controllers;

use flight\Engine;
use app\models\Fornecedor;

class FornecedorController
{
    private Engine $app;
    private $fornecedorModel;

    public function __construct(Engine $app)
    {
        $this->app = $app;
        $this->fornecedorModel = new Fornecedor();
    }

    /**
     * Lista todos os fornecedores
     */
    public function index(): void
    {
        $request = $this->app->request();
        $regiao = $request->query->regiao ?? 'todas';
        $especialidade = $request->query->especialidade ?? 'todas';
        
        $fornecedores = $this->fornecedorModel->getAtivos($regiao, $especialidade);
        
        // Process data - fornecedores is already an array
        $fornecedores = array_map(function($fornecedor) {
            return $this->fornecedorModel->processarDados($fornecedor);
        }, $fornecedores);
        
        $data = [
            'page_title' => 'Fornecedores Parceiros - Tronco Forte',
            'meta_description' => 'Conecte-se com nossa rede de fornecedores especializados em madeira de qualidade. Encontre o parceiro ideal para seu projeto.',
            'fornecedores' => $fornecedores,
            'regioes' => $this->fornecedorModel->getRegioes(),
            'especialidades' => $this->fornecedorModel->getEspecialidades(),
            'regiao_atual' => $regiao,
            'especialidade_atual' => $especialidade
        ];

        // Set the content for the layout
        $content = $this->app->view()->fetch('fornecedor/index', $data);
        $data['content'] = $content;
        
        // Render with layout
        $this->app->render('layout', $data);
    }

    /**
     * Exibe página individual do fornecedor (estilo Linktree)
     */
    public function perfil(string $slug): void
    {
        $fornecedor = $this->fornecedorModel->getBySlug($slug);
        
        if (!$fornecedor) {
            $this->app->halt(404, 'Fornecedor não encontrado');
        }
        
        // Process data - fornecedor is already an array
        $fornecedor = $this->fornecedorModel->processarDados($fornecedor);
        
        $data = [
            'page_title' => $fornecedor['nome'] . ' - Fornecedor Tronco Forte',
            'meta_description' => $fornecedor['descricao'],
            'fornecedor' => $fornecedor
        ];

        // Set the content for the layout
        $content = $this->app->view()->fetch('fornecedor/perfil', $data);
        $data['content'] = $content;
        
        // Render with layout
        $this->app->render('layout', $data);
    }

    /**
     * API para filtrar fornecedores
     */
    public function filtrar(): void
    {
        $request = $this->app->request();
        $regiao = $request->data->regiao ?? 'todas';
        $especialidade = $request->data->especialidade ?? 'todas';
        $termo = $request->data->termo ?? '';
        
        $fornecedores = $this->fornecedorModel->buscar($regiao, $especialidade, $termo);
        
        $this->app->json([
            'fornecedores' => $fornecedores,
            'total' => count($fornecedores)
        ]);
    }

    /**
     * Registra clique em link do fornecedor
     */
    public function registrarClique(): void
    {
        $request = $this->app->request();
        $fornecedor_id = (int) $request->data->fornecedor_id;
        $link_tipo = $request->data->link_tipo;
        
        // Aqui você registraria o clique no banco de dados
        // Por enquanto, apenas retornamos sucesso
        
        $this->app->json([
            'sucesso' => true,
            'mensagem' => 'Clique registrado com sucesso'
        ]);
    }


}