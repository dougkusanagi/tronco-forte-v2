<?php

use app\controllers\ApiExampleController;
use app\controllers\HomeController;
use app\controllers\CatalogoController;
use app\controllers\BlogController;
use app\controllers\FornecedorController;
use app\controllers\AdminController;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// Home route
$router->get('/', [HomeController::class, 'index']);

// Catálogo routes
$router->get('/catalogo', [CatalogoController::class, 'index']);
$router->get('/catalogo/produto/@id:[0-9]+', [CatalogoController::class, 'produto']);
$router->get('/catalogo/@slug', [CatalogoController::class, 'produto']);

// Blog routes
$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/@slug', [BlogController::class, 'artigo']);

// Fornecedores routes
$router->get('/fornecedores', [FornecedorController::class, 'index']);
$router->get('/fornecedor/@slug', [FornecedorController::class, 'perfil']);

// Static pages
$router->get('/contato', [HomeController::class, 'contato']);
$router->get('/sobre', [HomeController::class, 'sobre']);

// Admin routes
$router->get('/admin/login', [AdminController::class, 'login']);
$router->post('/admin/authenticate', [AdminController::class, 'authenticate']);
$router->get('/admin/logout', [AdminController::class, 'logout']);

// Admin dashboard
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/dashboard', [AdminController::class, 'dashboard']);
$router->get('/admin/produtos', [AdminController::class, 'produtos']);
$router->get('/admin/fornecedores', [AdminController::class, 'fornecedores']);
$router->get('/admin/blog', [AdminController::class, 'blog']);
$router->get('/admin/blog/novo', [AdminController::class, 'novoArtigo']);
$router->get('/admin/blog/editar/@id:[0-9]+', [AdminController::class, 'editarArtigo']);
// $router->get('/admin/relatorios', [AdminController::class, 'relatorios']); // Disabled for now
$router->get('/admin/configuracoes', [AdminController::class, 'configuracoes']);

// Dynamic route example
$router->get('/hello-world/@name', function($name) {
	echo '<h1>Hello world! Oh hey '.$name.'!</h1>';
});

// API routes group
$router->group('/api', function() use ($router, $app) {
	// Home APIs
	$router->post('/calcular-volume', [HomeController::class, 'calcularVolume']);
	$router->post('/quiz-madeira', [HomeController::class, 'quizMadeira']);
	
	// Catálogo APIs
	$router->post('/catalogo/filtrar', [CatalogoController::class, 'filtrar']);
	
	// Blog APIs
	$router->post('/blog/buscar', [BlogController::class, 'buscar']);
	
	// Fornecedores APIs
	$router->post('/fornecedores/filtrar', [FornecedorController::class, 'filtrar']);
	$router->post('/fornecedores/clique', [FornecedorController::class, 'registrarClique']);
	
	// Admin API routes
    $router->post('/admin/produtos/salvar', [AdminController::class, 'salvarProduto']);
    $router->post('/admin/produtos/excluir', [AdminController::class, 'excluirProduto']);
    $router->post('/admin/fornecedor', [AdminController::class, 'salvarFornecedor']);
    $router->post('/admin/artigo', [AdminController::class, 'salvarArtigo']);
    $router->delete('/admin/artigo', [AdminController::class, 'excluirArtigo']);
    $router->get('/admin/dashboard-dados', [AdminController::class, 'dadosDashboard']);
	
	// Original API examples
	$Api_Example_Controller = new ApiExampleController($app);
	$router->get('/users', [ $Api_Example_Controller, 'getUsers' ]);
	$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);
	$router->post('/users/@id:[0-9]', [ $Api_Example_Controller, 'updateUser' ]);
});