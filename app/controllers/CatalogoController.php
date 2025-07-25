<?php

namespace app\controllers;

use flight\Engine;

class CatalogoController
{
    private Engine $app;

    public function __construct(Engine $app)
    {
        $this->app = $app;
    }

    /**
     * Lista todos os produtos do catálogo
     */
    public function index(): void
    {
        $request = $this->app->request();
        $filtro_categoria = $request->query->categoria ?? 'todos';
        $filtro_aplicacao = $request->query->aplicacao ?? 'todas';
        
        $produtos = $this->obterProdutos($filtro_categoria, $filtro_aplicacao);
        
        $data = [
            'page_title' => 'Catálogo de Madeiras - Tronco Forte',
            'meta_description' => 'Catálogo completo de madeiras legalizadas. Pinus, eucalipto, ipê, cumaru e mais espécies com certificação de origem.',
            'produtos' => $produtos,
            'categorias' => $this->obterCategorias(),
            'aplicacoes' => $this->obterAplicacoes(),
            'filtro_categoria' => $filtro_categoria,
            'filtro_aplicacao' => $filtro_aplicacao
        ];

        // Set the content for the layout
        $content = $this->app->view()->fetch('catalogo/index', $data);
        $data['content'] = $content;
        
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
            $produto = $this->obterProdutoPorId((int)$id);
        } else {
            $produto = $this->obterProdutoPorSlug($id);
        }
        
        if (!$produto) {
            $this->app->halt(404, 'Produto não encontrado');
        }
        
        $data = [
            'page_title' => $produto['nome'] . ' - Tronco Forte',
            'meta_description' => $produto['descricao_completa'],
            'produto' => $produto,
            'produtos_relacionados' => $this->obterProdutosRelacionados($produto['categoria'], $produto['id'])
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
        
        $produtos = $this->obterProdutos($categoria, $aplicacao, $preco_min, $preco_max);
        
        $this->app->json([
            'produtos' => $produtos,
            'total' => count($produtos)
        ]);
    }

    private function obterProdutos(string $categoria = 'todos', string $aplicacao = 'todas', float $preco_min = 0, float $preco_max = 9999): array
    {
        $produtos_completos = [
            [
                'id' => 1,
                'nome' => 'Pinus Tratado',
                'categoria' => 'estrutural',
                'preco_m3' => 450,
                'preco_formatado' => 'R$ 450',
                'aplicacoes' => ['estruturas', 'telhados', 'andaimes'],
                'descricao' => 'Madeira de pinus tratada em autoclave, ideal para estruturas.',
                'descricao_completa' => 'Madeira de pinus tratada em autoclave com CCA (Arseniato de Cobre Cromatado), oferecendo proteção contra fungos, brocas e cupins. Ideal para estruturas, telhados e construções em geral.',
                'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=treated%20pine%20lumber%20stack%20construction%20grade%20wood%20planks%20professional%20photography&image_size=square_hd',
                'galeria' => [
                    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=treated%20pine%20lumber%20close%20up%20texture%20wood%20grain&image_size=landscape_4_3',
                    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=pine%20wood%20construction%20site%20framing%20structure&image_size=landscape_4_3'
                ],
                'certificacoes' => ['FSC', 'IBAMA'],
                'especificacoes' => [
                    'Densidade' => '450-550 kg/m³',
                    'Umidade' => '12-18%',
                    'Tratamento' => 'CCA em autoclave',
                    'Dimensões' => 'Sob medida'
                ],
                'disponibilidade' => 'Em estoque'
            ],
            [
                'id' => 2,
                'nome' => 'Eucalipto Beneficiado',
                'categoria' => 'acabamento',
                'preco_m3' => 380,
                'preco_formatado' => 'R$ 380',
                'aplicacoes' => ['formas', 'escoramentos', 'pallets'],
                'descricao' => 'Eucalipto beneficiado, versátil e econômico.',
                'descricao_completa' => 'Madeira de eucalipto beneficiada, seca em estufa e aparelhada. Excelente para formas de concreto, escoramentos e fabricação de pallets. Boa relação custo-benefício.',
                'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=eucalyptus%20processed%20lumber%20smooth%20finish%20construction%20wood%20professional%20photography&image_size=square_hd',
                'galeria' => [
                    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=eucalyptus%20wood%20texture%20close%20up%20smooth%20finish&image_size=landscape_4_3',
                    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=eucalyptus%20lumber%20stack%20warehouse%20organized&image_size=landscape_4_3'
                ],
                'certificacoes' => ['FSC', 'IBAMA'],
                'especificacoes' => [
                    'Densidade' => '600-800 kg/m³',
                    'Umidade' => '10-15%',
                    'Acabamento' => 'Aparelhado 4 faces',
                    'Dimensões' => 'Padrão e sob medida'
                ],
                'disponibilidade' => 'Em estoque'
            ],
            [
                'id' => 3,
                'nome' => 'Ipê para Deck',
                'categoria' => 'deck',
                'preco_m3' => 1200,
                'preco_formatado' => 'R$ 1.200',
                'aplicacoes' => ['decks', 'pisos_externos', 'moveis'],
                'descricao' => 'Ipê premium, a madeira mais nobre do Brasil.',
                'descricao_completa' => 'Madeira de ipê de primeira qualidade, extremamente durável e resistente. Ideal para decks, pisos externos e móveis de alto padrão. Beleza natural incomparável.',
                'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=ipe%20hardwood%20deck%20boards%20premium%20tropical%20wood%20planks%20professional%20photography&image_size=square_hd',
                'galeria' => [
                    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=ipe%20wood%20deck%20outdoor%20luxury%20finish&image_size=landscape_4_3',
                    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=ipe%20wood%20grain%20texture%20close%20up%20premium%20quality&image_size=landscape_4_3'
                ],
                'certificacoes' => ['FSC', 'IBAMA', 'CITES'],
                'especificacoes' => [
                    'Densidade' => '950-1200 kg/m³',
                    'Umidade' => '8-12%',
                    'Durabilidade' => 'Classe I (muito alta)',
                    'Dimensões' => 'Sob medida'
                ],
                'disponibilidade' => 'Sob consulta'
            ],
            [
                'id' => 4,
                'nome' => 'Cumaru',
                'categoria' => 'deck',
                'preco_m3' => 950,
                'preco_formatado' => 'R$ 950',
                'aplicacoes' => ['decks', 'estruturas_pesadas', 'pisos'],
                'descricao' => 'Cumaru, alternativa premium ao ipê.',
                'descricao_completa' => 'Madeira de cumaru de alta qualidade, conhecida por sua durabilidade e resistência. Excelente alternativa ao ipê com ótima relação custo-benefício.',
                'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=cumaru%20hardwood%20planks%20premium%20tropical%20lumber%20professional%20photography&image_size=square_hd',
                'galeria' => [
                    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=cumaru%20wood%20deck%20installation%20outdoor%20construction&image_size=landscape_4_3',
                    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=cumaru%20wood%20texture%20grain%20pattern%20close%20up&image_size=landscape_4_3'
                ],
                'certificacoes' => ['FSC', 'IBAMA'],
                'especificacoes' => [
                    'Densidade' => '850-1000 kg/m³',
                    'Umidade' => '8-12%',
                    'Durabilidade' => 'Classe I (muito alta)',
                    'Dimensões' => 'Padrão e sob medida'
                ],
                'disponibilidade' => 'Em estoque'
            ],
            [
                'id' => 5,
                'nome' => 'Jatobá',
                'categoria' => 'acabamento',
                'preco_m3' => 800,
                'preco_formatado' => 'R$ 800',
                'aplicacoes' => ['pisos', 'moveis', 'acabamentos'],
                'descricao' => 'Jatobá, madeira nobre para acabamentos.',
                'descricao_completa' => 'Madeira de jatobá com coloração avermelhada característica. Muito utilizada em pisos, móveis e acabamentos de alto padrão. Excelente trabalhabilidade.',
                'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=jatoba%20hardwood%20flooring%20planks%20reddish%20brown%20wood%20professional%20photography&image_size=square_hd',
                'galeria' => [
                    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=jatoba%20wood%20flooring%20installation%20interior%20luxury&image_size=landscape_4_3',
                    'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=jatoba%20wood%20grain%20reddish%20color%20texture%20detail&image_size=landscape_4_3'
                ],
                'certificacoes' => ['FSC', 'IBAMA'],
                'especificacoes' => [
                    'Densidade' => '750-900 kg/m³',
                    'Umidade' => '8-12%',
                    'Cor' => 'Avermelhada',
                    'Dimensões' => 'Padrão e sob medida'
                ],
                'disponibilidade' => 'Em estoque'
            ]
        ];
        
        // Aplicar filtros
        $produtos_filtrados = array_filter($produtos_completos, function($produto) use ($categoria, $aplicacao, $preco_min, $preco_max) {
            $categoria_ok = ($categoria === 'todos' || $produto['categoria'] === $categoria);
            $aplicacao_ok = ($aplicacao === 'todas' || in_array($aplicacao, $produto['aplicacoes']));
            $preco_ok = ($produto['preco_m3'] >= $preco_min && $produto['preco_m3'] <= $preco_max);
            
            return $categoria_ok && $aplicacao_ok && $preco_ok;
        });
        
        return array_values($produtos_filtrados);
    }

    private function obterProdutoPorId(int $id): ?array
    {
        $produtos = $this->obterProdutos();
        
        foreach ($produtos as $produto) {
            if ($produto['id'] === $id) {
                return $produto;
            }
        }
        
        return null;
    }

    private function obterProdutoPorSlug(string $slug): ?array
    {
        $produtos = $this->obterProdutos();
        
        foreach ($produtos as $produto) {
            $produto_slug = strtolower(str_replace(' ', '-', $produto['nome']));
            if ($produto_slug === $slug) {
                return $produto;
            }
        }
        
        return null;
    }

    private function obterProdutosRelacionados(string $categoria, int $excluir_id): array
    {
        $produtos = $this->obterProdutos($categoria);
        
        return array_filter($produtos, function($produto) use ($excluir_id) {
            return $produto['id'] !== $excluir_id;
        });
    }

    private function obterCategorias(): array
    {
        return [
            'todos' => 'Todas as Categorias',
            'estrutural' => 'Estrutural',
            'acabamento' => 'Acabamento',
            'deck' => 'Deck e Pisos'
        ];
    }

    private function obterAplicacoes(): array
    {
        return [
            'todas' => 'Todas as Aplicações',
            'estruturas' => 'Estruturas',
            'decks' => 'Decks',
            'pisos_externos' => 'Pisos Externos',
            'formas' => 'Formas de Concreto',
            'acabamentos' => 'Acabamentos',
            'moveis' => 'Móveis',
            'telhados' => 'Telhados'
        ];
    }
}