<?php

namespace app\controllers;

use app\utils\UrlHelper;
use flight\Engine;

class HomeController
{
    private Engine $app;

    public function __construct(Engine $app)
    {
        $this->app = $app;
    }

    /**
     * Exibe a página inicial com todas as seções
     */
    public function index(): void
    {
        // Dados para a homepage
        $data = [
            'page_title' => 'Tronco Forte - Madeira 100% Legal para Sua Obra',
            'meta_description' => 'Madeira legalizada para construção civil e marcenaria. Pinus, eucalipto, ipê e cumaru com certificação de origem. Qualidade garantida para sua obra.',
            'meta_keywords' => 'madeira legalizada, madeira construção civil, madeira serrada, pinus tratado, eucalipto beneficiado, ipê deck',
            'hero' => [
                'titulo' => 'Madeira 100% Legal para Sua Obra',
                'subtitulo' => 'Construa com segurança e sustentabilidade. Madeira certificada direto da floresta para seu projeto.',
                'image' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=sustainable%20forest%20logging%20operation%20with%20heavy%20machinery%20and%20workers%20in%20safety%20gear%20cinematic%20style&image_size=landscape_16_9',
                'cta_primario' => 'Calcular Minha Necessidade',
                'cta_secundario' => 'Falar no WhatsApp'
            ],
            'stats' => [
                'metros_cubicos_entregues' => 15420,
                'clientes_atendidos' => 850,
                'especies_disponiveis' => 12,
                'anos_mercado' => 15
            ],
            'produtos_destaque' => [
                [
                    'id' => 1,
                    'nome' => 'Pinus Tratado',
                    'categoria' => 'estrutural',
                    'preco_m3' => 'R$ 450',
                    'aplicacoes' => ['Estruturas', 'Telhados', 'Andaimes'],
                    'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=treated%20pine%20lumber%20stack%20construction%20grade%20wood%20planks%20professional%20photography&image_size=square_hd',
                    'certificacoes' => ['FSC', 'IBAMA']
                ],
                [
                    'id' => 2,
                    'nome' => 'Eucalipto Beneficiado',
                    'categoria' => 'acabamento',
                    'preco_m3' => 'R$ 380',
                    'aplicacoes' => ['Formas', 'Escoramentos', 'Pallets'],
                    'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=eucalyptus%20processed%20lumber%20smooth%20finish%20construction%20wood%20professional%20photography&image_size=square_hd',
                    'certificacoes' => ['FSC', 'IBAMA']
                ],
                [
                    'id' => 3,
                    'nome' => 'Ipê para Deck',
                    'categoria' => 'deck',
                    'preco_m3' => 'R$ 1200',
                    'aplicacoes' => ['Decks', 'Pisos externos', 'Móveis'],
                    'imagem' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=ipe%20hardwood%20deck%20boards%20premium%20tropical%20wood%20planks%20professional%20photography&image_size=square_hd',
                    'certificacoes' => ['FSC', 'IBAMA', 'CITES']
                ]
            ],
            'depoimentos' => [
                [
                    'nome' => 'João Silva',
                    'empresa' => 'Construtora Silva & Filhos',
                    'texto' => 'Trabalho com a Tronco Forte há 5 anos. Madeira sempre de qualidade e com toda documentação em dia.',
                    'rating' => 5
                ],
                [
                    'nome' => 'Maria Santos',
                    'empresa' => 'Marcenaria Santos',
                    'texto' => 'Excelente atendimento e produtos de primeira linha. Recomendo para qualquer projeto.',
                    'rating' => 5
                ]
            ]
        ];

        // Set the content for the layout
        $content = $this->app->view()->fetch('home/index', $data);
        $data['content'] = $content;
        $data['base_path'] = UrlHelper::getBasePath();
        $data['url_helper'] = UrlHelper::class;
        
        // Render with layout
        $this->app->render('layout', $data);
    }

    /**
     * API para calculadora de m³
     */
    public function calcularVolume(): void
    {
        $request = $this->app->request();
        
        $tipo_projeto = $request->data->tipo_projeto ?? '';
        $comprimento = (float) ($request->data->comprimento ?? 0);
        $largura = (float) ($request->data->largura ?? 0);
        $altura = (float) ($request->data->altura ?? 0);
        
        $volume = 0;
        $recomendacoes = [];
        
        switch ($tipo_projeto) {
            case 'deck':
                $volume = ($comprimento * $largura * 0.025) * 1.1; // 2.5cm espessura + 10% desperdício
                $recomendacoes = ['Ipê', 'Cumaru', 'Jatobá'];
                break;
            case 'estrutura':
                $volume = ($comprimento * $largura * $altura) * 0.15; // 15% da estrutura em madeira
                $recomendacoes = ['Pinus Tratado', 'Eucalipto Citriodora'];
                break;
            case 'acabamento':
                $volume = ($comprimento * $largura * 0.02) * 1.15; // 2cm espessura + 15% desperdício
                $recomendacoes = ['Eucalipto Beneficiado', 'Pinus Aparelhado'];
                break;
            default:
                $volume = $comprimento * $largura * $altura;
                $recomendacoes = ['Consulte nosso especialista'];
        }
        
        $this->app->json([
            'volume_m3' => round($volume, 2),
            'tipo_projeto' => $tipo_projeto,
            'recomendacoes' => $recomendacoes,
            'preco_estimado' => 'R$ ' . number_format($volume * 500, 2, ',', '.') // Preço médio estimado
        ]);
    }

    /**
     * API para quiz de madeira ideal
     */
    public function quizMadeira(): void
    {
        $request = $this->app->request();
        
        $respostas = $request->data->respostas ?? [];
        $recomendacao = $this->processarQuizMadeira($respostas);
        
        $this->app->json($recomendacao);
    }

    private function processarQuizMadeira(array $respostas): array
    {
        // Lógica simplificada do quiz
        $pontuacao = [
            'pinus' => 0,
            'eucalipto' => 0,
            'ipe' => 0,
            'cumaru' => 0
        ];
        
        foreach ($respostas as $resposta) {
            switch ($resposta) {
                case 'uso_externo':
                    $pontuacao['ipe'] += 3;
                    $pontuacao['cumaru'] += 3;
                    break;
                case 'uso_interno':
                    $pontuacao['pinus'] += 2;
                    $pontuacao['eucalipto'] += 2;
                    break;
                case 'orcamento_baixo':
                    $pontuacao['eucalipto'] += 3;
                    $pontuacao['pinus'] += 2;
                    break;
                case 'orcamento_alto':
                    $pontuacao['ipe'] += 3;
                    $pontuacao['cumaru'] += 2;
                    break;
                case 'durabilidade_alta':
                    $pontuacao['ipe'] += 3;
                    $pontuacao['cumaru'] += 2;
                    break;
            }
        }
        
        $madeira_recomendada = array_keys($pontuacao, max($pontuacao))[0];
        
        $recomendacoes = [
            'pinus' => [
                'nome' => 'Pinus Tratado',
                'descricao' => 'Ideal para estruturas e projetos internos. Excelente custo-benefício.',
                'preco_m3' => 'R$ 450',
                'vantagens' => ['Preço acessível', 'Fácil trabalhabilidade', 'Tratamento contra pragas']
            ],
            'eucalipto' => [
                'nome' => 'Eucalipto Beneficiado',
                'descricao' => 'Versátil e econômico. Perfeito para formas e acabamentos.',
                'preco_m3' => 'R$ 380',
                'vantagens' => ['Melhor preço', 'Boa resistência', 'Sustentável']
            ],
            'ipe' => [
                'nome' => 'Ipê Premium',
                'descricao' => 'A madeira mais nobre. Extrema durabilidade e beleza.',
                'preco_m3' => 'R$ 1200',
                'vantagens' => ['Máxima durabilidade', 'Resistente a intempéries', 'Beleza natural']
            ],
            'cumaru' => [
                'nome' => 'Cumaru',
                'descricao' => 'Alternativa premium ao ipê. Ótima para áreas externas.',
                'preco_m3' => 'R$ 950',
                'vantagens' => ['Alta durabilidade', 'Boa relação custo-benefício', 'Resistente']
            ]
        ];
        
        return $recomendacoes[$madeira_recomendada];
    }

    /**
     * Exibe a página de contato
     */
    public function contato(): void
    {
        $data = [
            'page_title' => 'Contato - Tronco Forte',
            'meta_description' => 'Entre em contato com a Tronco Forte. Solicite orçamentos, tire dúvidas e fale com nossos especialistas em madeira.',
            'meta_keywords' => 'contato tronco forte, orçamento madeira, falar especialista madeira'
        ];

        // Set the content for the layout
        $content = $this->app->view()->fetch('home/contato', $data);
        $data['content'] = $content;
        $data['base_path'] = UrlHelper::getBasePath();
        $data['url_helper'] = UrlHelper::class;
        
        // Render with layout
        $this->app->render('layout', $data);
    }

    /**
     * Exibe a página sobre
     */
    public function sobre(): void
    {
        $data = [
            'page_title' => 'Sobre Nós - Tronco Forte',
            'meta_description' => 'Conheça a história da Tronco Forte. 15 anos fornecendo madeira legalizada e certificada para construção civil e marcenaria.',
            'meta_keywords' => 'sobre tronco forte, história empresa, madeira legalizada, certificação florestal'
        ];

        // Set the content for the layout
        $content = $this->app->view()->fetch('home/sobre', $data);
        $data['content'] = $content;
        $data['base_path'] = UrlHelper::getBasePath();
        $data['url_helper'] = UrlHelper::class;
        
        // Render with layout
        $this->app->render('layout', $data);
    }
}