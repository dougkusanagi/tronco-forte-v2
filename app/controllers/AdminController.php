<?php

namespace app\controllers;

use Flight;
use Exception;
use flight\Engine;
use PDO;

class AdminController
{
    private Engine $app;

    public function __construct(Engine $app)
    {
        $this->app = $app;
    }

    /**
     * Dashboard principal do admin
     */
    public function dashboard(): void
    {
        // Verificar autenticação (implementar depois)
        $this->verificarAutenticacao();
        
        $data = [
            'page_title' => 'Dashboard Administrativo - Tronco Forte',
            'estatisticas' => $this->obterEstatisticas(),
            'atividades_recentes' => $this->obterAtividadesRecentes(),
            'alertas' => $this->obterAlertas()
        ];

        // Set the content for the admin layout
        $content = $this->app->view()->fetch('admin/dashboard', $data);
        $data['content'] = $content;
        
        // Render with admin layout
        $this->app->render('admin_layout', $data);
    }

    /**
     * Gerenciamento de fornecedores
     */
    public function fornecedores(): void
    {
        $this->verificarAutenticacao();
        
        $data = [
            'page_title' => 'Gerenciar Fornecedores - Admin',
            'fornecedores' => $this->obterFornecedoresAdmin(),
            'regioes' => $this->obterRegioesAdmin()
        ];

        // Set the content for the admin layout
        $content = $this->app->view()->fetch('admin/fornecedores', $data);
        $data['content'] = $content;
        
        // Render with admin layout
        $this->app->render('admin_layout', $data);
    }

    /**
     * Gerenciamento de artigos do blog
     */
    public function blog(): void
    {
        $this->verificarAutenticacao();
        
        $data = [
            'page_title' => 'Gerenciar Blog - Admin',
            'artigos' => $this->obterArtigosAdmin(),
            'categorias_blog' => $this->obterCategoriasBlogAdmin()
        ];

        // Set the content for the admin layout
        $content = $this->app->view()->fetch('admin/blog', $data);
        $data['content'] = $content;
        
        // Render with admin layout
        $this->app->render('admin_layout', $data);
    }

    /**
     * Gerenciamento de produtos
     */
    public function produtos(): void
    {
        $this->verificarAutenticacao();
        
        try {
            $produtos = $this->obterProdutosAdmin();
            $categorias = $this->obterCategoriasAdmin();
            
            $data = [
                'page_title' => 'Gerenciar Produtos - Admin',
                'produtos' => $produtos,
                'categorias' => $categorias
            ];
            
            // Set the content for the admin layout
            $content = $this->app->view()->fetch('admin/produtos', $data);
            $data['content'] = $content;
            
            // Render with admin layout
            $this->app->render('admin_layout', $data);
            
        } catch (Exception $e) {
            error_log('Error in produtos method: ' . $e->getMessage());
            Flight::halt(500, 'Internal Server Error: ' . $e->getMessage());
        }
    }

    /**
     * Relatórios e analytics
     */
    public function relatorios(): void
    {
        $this->verificarAutenticacao();
        
        $data = [
            'page_title' => 'Relatórios - Admin',
            'metricas_site' => $this->obterMetricasSite(),
            'relatorio_vendas' => $this->obterRelatorioVendas(),
            'relatorio_fornecedores' => $this->obterRelatorioFornecedores()
        ];

        // Set the content for the admin layout
        $content = $this->app->view()->fetch('admin/relatorios', $data);
        $data['content'] = $content;
        
        // Render with admin layout
        $this->app->render('admin_layout', $data);
    }

    /**
     * Configurações do sistema
     */
    public function configuracoes(): void
    {
        $this->verificarAutenticacao();
        
        $data = [
            'page_title' => 'Configurações - Admin',
            'configuracoes_site' => $this->obterConfiguracoesSite(),
            'configuracoes_seo' => $this->obterConfiguracoesSeo()
        ];

        // Set the content for the admin layout
        $content = $this->app->view()->fetch('admin/configuracoes', $data);
        $data['content'] = $content;
        
        // Render with admin layout
        $this->app->render('admin_layout', $data);
    }

    /**
     * API para salvar produto
     */
    public function salvarProduto(): void
    {
        $this->verificarAutenticacao();
        
        $request = $this->app->request();
        $dados = [
            'nome' => $request->data->nome,
            'categoria' => $request->data->categoria,
            'preco' => (float) $request->data->preco,
            'descricao' => $request->data->descricao,
            'especificacoes' => $request->data->especificacoes,
            'disponibilidade' => $request->data->disponibilidade
        ];
        
        // Aqui você salvaria no banco de dados
        // Por enquanto, apenas simular sucesso
        
        $this->app->json([
            'sucesso' => true,
            'mensagem' => 'Produto salvo com sucesso',
            'produto_id' => rand(1000, 9999)
        ]);
    }

    /**
     * API para salvar fornecedor
     */
    public function salvarFornecedor(): void
    {
        $this->verificarAutenticacao();
        
        $request = $this->app->request();
        $dados = [
            'nome' => $request->data->nome,
            'slug' => $request->data->slug,
            'descricao' => $request->data->descricao,
            'regiao' => $request->data->regiao,
            'cidade' => $request->data->cidade,
            'especialidades' => $request->data->especialidades,
            'links' => $request->data->links
        ];
        
        // Aqui você salvaria no banco de dados
        
        $this->app->json([
            'sucesso' => true,
            'mensagem' => 'Fornecedor salvo com sucesso',
            'fornecedor_id' => rand(1000, 9999)
        ]);
    }

    /**
     * API para salvar artigo do blog
     */
    public function salvarArtigo(): void
    {
        $this->verificarAutenticacao();
        
        $request = $this->app->request();
        $data = $request->data;
        
        try {
            $db = Flight::db();
            
            // Validate required fields
            if (empty($data->title) || empty($data->content)) {
                $this->app->json(['success' => false, 'message' => 'Título e conteúdo são obrigatórios']);
                return;
            }
            
            // Generate slug from title
            $slug = $this->generateSlug($data->title);
            
            if (isset($data->id) && !empty($data->id)) {
                // Update existing article
                $stmt = $db->prepare("
                    UPDATE blog_posts SET 
                        title = ?, 
                        slug = ?, 
                        content = ?, 
                        excerpt = ?, 
                        category_id = ?, 
                        status = ?, 
                        updated_at = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([
                    $data->title,
                    $slug,
                    $data->content,
                    $data->excerpt ?? '',
                    $data->category_id ?? null,
                    $data->status ?? 'draft',
                    $data->id
                ]);
                $message = 'Artigo atualizado com sucesso!';
            } else {
                // Create new article
                $stmt = $db->prepare("
                    INSERT INTO blog_posts (title, slug, content, excerpt, category_id, status, author_id, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, ?, 1, NOW(), NOW())
                ");
                $stmt->execute([
                    $data->title,
                    $slug,
                    $data->content,
                    $data->excerpt ?? '',
                    $data->category_id ?? null,
                    $data->status ?? 'draft'
                ]);
                $message = 'Artigo criado com sucesso!';
            }
            
            $this->app->json(['success' => true, 'message' => $message]);
        } catch (Exception $e) {
            error_log('Erro ao salvar artigo: ' . $e->getMessage());
            $this->app->json(['success' => false, 'message' => 'Erro ao salvar artigo']);
        }
    }

    /**
     * API para obter dados do dashboard
     */
    public function dadosDashboard(): void
    {
        $this->verificarAutenticacao();
        
        $this->app->json([
            'estatisticas' => $this->obterEstatisticas(),
            'grafico_vendas' => $this->obterDadosGraficoVendas(),
            'top_produtos' => $this->obterTopProdutos(),
            'atividades_recentes' => $this->obterAtividadesRecentes()
        ]);
    }

    /**
     * Página de login
     */
    public function login(): void
    {
        // Se já está autenticado, redirecionar para dashboard
        if ($this->estaAutenticado()) {
            $this->app->redirect('/admin/dashboard');
            return;
        }
        
        $this->app->render('admin/login');
    }
    
    /**
     * Processar autenticação
     */
    public function authenticate(): void
    {
        $request = $this->app->request();
        $username = $request->data->username ?? '';
        $password = $request->data->password ?? '';
        
        // Credenciais padrão
        $defaultUsername = 'admin';
        $defaultPassword = 'admin123';
        
        if ($username === $defaultUsername && $password === $defaultPassword) {
            // Iniciar sessão
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $username;
            $_SESSION['admin_login_time'] = time();
            
            $this->app->json([
                'success' => true,
                'message' => 'Login realizado com sucesso'
            ]);
        } else {
            $this->app->json([
                'success' => false,
                'message' => 'Credenciais inválidas'
            ]);
        }
    }
    
    /**
     * Logout
     */
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Limpar sessão
        unset($_SESSION['admin_logged_in']);
        unset($_SESSION['admin_user']);
        unset($_SESSION['admin_login_time']);
        
        // Destruir sessão se estiver vazia
        if (empty($_SESSION)) {
            session_destroy();
        }
        
        $this->app->redirect('/admin/login');
    }
    
    /**
     * Verificar se está autenticado
     */
    private function estaAutenticado(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
    
    private function verificarAutenticacao(): void
    {
        if (!$this->estaAutenticado()) {
            $this->app->redirect('/admin/login');
        }
    }

    private function obterEstatisticas(): array
    {
        try {
            $db = Flight::db();
            
            // Contar fornecedores
            $stmt = $db->prepare("SELECT COUNT(*) as total FROM fornecedores");
            $stmt->execute();
            $totalFornecedores = $stmt->fetch()['total'];
            
            // Contar artigos do blog
            $stmt = $db->prepare("SELECT COUNT(*) as total FROM blog_posts");
            $stmt->execute();
            $totalArtigos = $stmt->fetch()['total'];
            
            return [
                'total_produtos' => 156, // Manter valor fixo por enquanto
                'total_fornecedores' => $totalFornecedores,
                'total_artigos' => $totalArtigos,
                'visitantes_mes' => 12450,
                'orcamentos_mes' => 89,
                'conversao_mes' => 7.2,
                'receita_estimada' => 'R$ 245.000'
            ];
        } catch (Exception $e) {
            error_log('Erro ao obter estatísticas: ' . $e->getMessage());
            // Retornar dados padrão em caso de erro
            return [
                'total_produtos' => 0,
                'total_fornecedores' => 0,
                'total_artigos' => 0,
                'visitantes_mes' => 0,
                'orcamentos_mes' => 0,
                'conversao_mes' => 0,
                'receita_estimada' => 'R$ 0'
            ];
        }
    }

    private function obterAtividadesRecentes(): array
    {
        return [
            [
                'tipo' => 'produto',
                'acao' => 'Novo produto adicionado',
                'descricao' => 'Ipê Premium para Deck',
                'data' => '2024-01-15 14:30',
                'usuario' => 'Admin'
            ],
            [
                'tipo' => 'fornecedor',
                'acao' => 'Fornecedor atualizado',
                'descricao' => 'Madeireira São Paulo - novos links',
                'data' => '2024-01-15 11:20',
                'usuario' => 'Admin'
            ],
            [
                'tipo' => 'blog',
                'acao' => 'Artigo publicado',
                'descricao' => 'Guia de Instalação de Decks',
                'data' => '2024-01-14 16:45',
                'usuario' => 'Editor'
            ],
            [
                'tipo' => 'sistema',
                'acao' => 'Backup realizado',
                'descricao' => 'Backup automático do banco de dados',
                'data' => '2024-01-14 02:00',
                'usuario' => 'Sistema'
            ]
        ];
    }

    private function obterAlertas(): array
    {
        return [
            [
                'tipo' => 'warning',
                'titulo' => 'Estoque Baixo',
                'mensagem' => '3 produtos com estoque abaixo do mínimo',
                'acao' => '/admin/produtos?filtro=estoque_baixo'
            ],
            [
                'tipo' => 'info',
                'titulo' => 'Novos Orçamentos',
                'mensagem' => '5 novos orçamentos aguardando resposta',
                'acao' => '/admin/orcamentos'
            ],
            [
                'tipo' => 'success',
                'titulo' => 'Meta Atingida',
                'mensagem' => 'Meta de visitantes do mês foi superada!',
                'acao' => '/admin/relatorios'
            ]
        ];
    }

    private function obterProdutosAdmin(): array
    {
        return [
            [
                'id' => 1,
                'nome' => 'Pinus Tratado',
                'categoria' => 'Estrutural',
                'preco' => 450,
                'estoque' => 'Em estoque',
                'status' => 'Ativo',
                'visualizacoes' => 1250,
                'ultima_atualizacao' => '2024-01-10'
            ],
            [
                'id' => 2,
                'nome' => 'Ipê para Deck',
                'categoria' => 'Deck',
                'preco' => 1200,
                'estoque' => 'Baixo',
                'status' => 'Ativo',
                'visualizacoes' => 890,
                'ultima_atualizacao' => '2024-01-08'
            ]
        ];
    }

    private function obterFornecedoresAdmin(): array
    {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("
                SELECT 
                    id,
                    nome,
                    especialidades as categoria,
                    regiao,
                    CASE WHEN ativo = 1 THEN 'Ativo' ELSE 'Inativo' END as status,
                    0 as total_cliques,
                    COALESCE(avaliacao, 0) as avaliacao,
                    DATE(created_at) as ultima_atualizacao
                FROM fornecedores 
                ORDER BY created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Erro ao obter fornecedores admin: ' . $e->getMessage());
            return [];
        }
    }

    private function obterArtigosAdmin(): array
    {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("
                SELECT 
                    p.id,
                    p.title,
                    p.title as titulo,
                    c.name as categoria,
                    CASE WHEN p.status = 'published' THEN 'Publicado' ELSE 'Rascunho' END as status,
                    COALESCE(p.views, 0) as visualizacoes,
                    DATE(p.created_at) as data_publicacao,
                    'Admin' as autor
                FROM blog_posts p
                LEFT JOIN blog_categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Erro ao obter artigos admin: ' . $e->getMessage());
            return [];
        }
    }

    private function obterCategoriasAdmin(): array
    {
        return ['Estrutural', 'Acabamento', 'Deck', 'Madeiras Nobres'];
    }

    private function obterRegioesAdmin(): array
    {
        return ['Norte', 'Nordeste', 'Centro-Oeste', 'Sudeste', 'Sul'];
    }


    private function obterCategoriasBlogAdmin(): array
    {
        return ['Técnico', 'Prático', 'Sustentabilidade', 'Espécies'];
    }

    private function obterMetricasSite(): array
    {
        try {
            $db = Flight::db();
            
            // Get total blog post views
            $stmt = $db->prepare("SELECT SUM(views) as total_views FROM blog_posts");
            $stmt->execute();
            $totalViews = $stmt->fetchColumn() ?: 0;
            
            // Since fornecedores table doesn't have total_cliques, we'll use a default value
            $totalClicks = 0;
            
            // Get most viewed blog posts
            $stmt = $db->prepare("
                SELECT 
                    CONCAT('/blog/', slug) as pagina,
                    views as visualizacoes
                FROM blog_posts 
                WHERE views > 0
                ORDER BY views DESC 
                LIMIT 3
            ");
            $stmt->execute();
            $paginasPopulares = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add default pages if not enough data
            if (count($paginasPopulares) < 3) {
                $defaultPages = [
                    ['pagina' => '/fornecedores', 'visualizacoes' => $totalClicks],
                ['pagina' => '/', 'visualizacoes' => 500],
                ['pagina' => '/blog', 'visualizacoes' => $totalViews]
                ];
                $paginasPopulares = array_merge($paginasPopulares, array_slice($defaultPages, count($paginasPopulares)));
                $paginasPopulares = array_slice($paginasPopulares, 0, 3);
            }
            
            return [
                'pageviews_mes' => $totalViews + $totalClicks + 1000, // Add base traffic
                'usuarios_unicos' => intval(($totalViews + $totalClicks) * 0.3), // Estimate unique users
                'taxa_rejeicao' => 35.2,
                'tempo_medio_sessao' => '3:45',
                'paginas_mais_visitadas' => $paginasPopulares
            ];
        } catch (Exception $e) {
            error_log('Erro ao obter métricas do site: ' . $e->getMessage());
            // Return default data on error
            return [
                'pageviews_mes' => 1000,
                'usuarios_unicos' => 300,
                'taxa_rejeicao' => 35.2,
                'tempo_medio_sessao' => '3:45',
                'paginas_mais_visitadas' => [
                    ['pagina' => '/fornecedores', 'visualizacoes' => 500],
                    ['pagina' => '/', 'visualizacoes' => 300],
                    ['pagina' => '/blog', 'visualizacoes' => 200]
                ]
            ];
        }
    }

    private function obterRelatorioVendas(): array
    {
        try {
            $db = Flight::db();
            
            // Get most viewed blog posts as proxy for most requested products
            $stmt = $db->prepare("
                SELECT 
                    title as produto,
                    views as cotacoes
                FROM blog_posts 
                WHERE views > 0
                ORDER BY views DESC 
                LIMIT 3
            ");
            $stmt->execute();
            $produtosMaisCotados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add default products if not enough data
            if (count($produtosMaisCotados) < 3) {
                $defaultProducts = [
                    ['produto' => 'Pinus Tratado', 'cotacoes' => 45],
                    ['produto' => 'Ipê para Deck', 'cotacoes' => 23],
                    ['produto' => 'Eucalipto', 'cotacoes' => 18]
                ];
                $produtosMaisCotados = array_merge($produtosMaisCotados, array_slice($defaultProducts, count($produtosMaisCotados)));
                $produtosMaisCotados = array_slice($produtosMaisCotados, 0, 3);
            }
            
            // Calculate estimates based on real data
            $totalCotacoes = array_sum(array_column($produtosMaisCotados, 'cotacoes'));
            $orcamentosMes = max($totalCotacoes, 20); // Minimum 20 quotes
            
            return [
                'orcamentos_mes' => $orcamentosMes,
                'conversao_orcamentos' => 7.2,
                'ticket_medio' => 'R$ 2.750',
                'produtos_mais_cotados' => $produtosMaisCotados
            ];
        } catch (Exception $e) {
            error_log('Erro ao obter relatório de vendas: ' . $e->getMessage());
            // Return default data on error
            return [
                'orcamentos_mes' => 20,
                'conversao_orcamentos' => 7.2,
                'ticket_medio' => 'R$ 2.750',
                'produtos_mais_cotados' => [
                    ['produto' => 'Pinus Tratado', 'cotacoes' => 15],
                    ['produto' => 'Ipê para Deck', 'cotacoes' => 10],
                    ['produto' => 'Eucalipto', 'cotacoes' => 8]
                ]
            ];
        }
    }

    private function obterRelatorioFornecedores(): array
    {
        try {
            $db = Flight::db();
            
            // Since fornecedores table doesn't have total_cliques, we'll use default values
            $totalCliques = 0;
            
            // Get most recent supplier as proxy for most accessed
            $stmt = $db->prepare("
                SELECT nome 
                FROM fornecedores 
                ORDER BY created_at DESC 
                LIMIT 1
            ");
            $stmt->execute();
            $fornecedorMaisAcessado = $stmt->fetchColumn() ?: 'Nenhum fornecedor';
            
            // Get most common region
            $stmt = $db->prepare("
                SELECT regiao, COUNT(*) as total_count
                FROM fornecedores 
                GROUP BY regiao 
                ORDER BY total_count DESC 
                LIMIT 1
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $regiaoMaisAtiva = $result ? ucfirst($result['regiao']) : 'Sudeste';
            
            return [
                'total_cliques' => $totalCliques,
                'fornecedor_mais_acessado' => $fornecedorMaisAcessado,
                'regiao_mais_ativa' => $regiaoMaisAtiva,
                'crescimento_mes' => 15.3
            ];
        } catch (Exception $e) {
            error_log('Erro ao obter relatório de fornecedores: ' . $e->getMessage());
            // Return default data on error
            return [
                'total_cliques' => 100,
                'fornecedor_mais_acessado' => 'Madeireira Exemplo',
                'regiao_mais_ativa' => 'Sudeste',
                'crescimento_mes' => 15.3
            ];
        }
    }

    private function obterConfiguracoesSite(): array
    {
        return [
            'nome_site' => 'Tronco Forte',
            'email_contato' => 'contato@troncoforte.com.br',
            'telefone_contato' => '(11) 3333-4444',
            'endereco' => 'São Paulo, SP',
            'redes_sociais' => [
                'instagram' => '@troncoforte',
                'linkedin' => 'tronco-forte',
                'youtube' => 'troncoforte'
            ]
        ];
    }

    private function obterConfiguracoesSeo(): array
    {
        return [
            'meta_title_home' => 'Tronco Forte - Madeiras Legalizadas para Construção',
            'meta_description_home' => 'Fornecedor de madeiras certificadas...',
            'google_analytics' => 'G-XXXXXXXXXX',
            'google_tag_manager' => 'GTM-XXXXXXX',
            'facebook_pixel' => '1234567890'
        ];
    }

    private function obterDadosGraficoVendas(): array
    {
        return [
            'labels' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            'datasets' => [
                [
                    'label' => 'Orçamentos',
                    'data' => [65, 78, 89, 95, 102, 89],
                    'borderColor' => '#8B4513',
                    'backgroundColor' => 'rgba(139, 69, 19, 0.1)'
                ]
            ]
        ];
    }

    /**
     * Editar artigo do blog
     */
    public function editarArtigo(int $id): void
    {
        $this->verificarAutenticacao();
        
        try {
            $db = Flight::db();
            $stmt = $db->prepare("
                SELECT p.*, c.name as categoria_nome
                FROM blog_posts p
                LEFT JOIN blog_categories c ON p.category_id = c.id
                WHERE p.id = ?
            ");
            $stmt->execute([$id]);
            $artigo = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$artigo) {
                $this->app->halt(404, 'Artigo não encontrado');
            }
            
            $categorias = $this->obterCategoriasBlogAdmin();
            
            $data = [
                'page_title' => 'Editar Artigo - Admin',
                'artigo' => $artigo,
                'categorias' => $categorias
            ];
            
            $content = $this->app->view()->fetch('admin/blog-form', $data);
            $data['content'] = $content;
            $this->app->render('admin_layout', $data);
        } catch (Exception $e) {
            error_log('Erro ao carregar artigo para edição: ' . $e->getMessage());
            $this->app->halt(500, 'Erro interno do servidor');
        }
    }
    
    /**
     * Novo artigo do blog
     */
    public function novoArtigo(): void
    {
        $this->verificarAutenticacao();
        
        $categorias = $this->obterCategoriasBlogAdmin();
        
        $data = [
            'page_title' => 'Novo Artigo - Admin',
            'artigo' => null,
            'categorias' => $categorias
        ];
        
        $content = $this->app->view()->fetch('admin/blog-form', $data);
        $data['content'] = $content;
        $this->app->render('admin_layout', $data);
    }
    
    /**
     * Excluir artigo do blog
     */
    public function excluirArtigo(): void
    {
        $this->verificarAutenticacao();
        
        $request = $this->app->request();
        $id = $request->data->id;
        
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM blog_posts WHERE id = ?");
            $stmt->execute([$id]);
            
            $this->app->json(['success' => true, 'message' => 'Artigo excluído com sucesso!']);
        } catch (Exception $e) {
            error_log('Erro ao excluir artigo: ' . $e->getMessage());
            $this->app->json(['success' => false, 'message' => 'Erro ao excluir artigo']);
        }
    }
    
    /**
     * Gerar slug único para artigo
     */
    private function generateSlug(string $title): string
    {
        // Convert to lowercase and replace spaces with hyphens
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Ensure uniqueness
        $db = Flight::db();
        $originalSlug = $slug;
        $counter = 1;
        
        while (true) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM blog_posts WHERE slug = ?");
            $stmt->execute([$slug]);
            if ($stmt->fetchColumn() == 0) {
                break;
            }
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    private function obterTopProdutos(): array
    {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("
                SELECT 
                    title as nome,
                    COALESCE(views, 0) as visualizacoes
                FROM blog_posts 
                ORDER BY views DESC, created_at DESC
                LIMIT 5
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Se não houver dados suficientes, adicionar dados padrão
            if (count($result) < 5) {
                $defaultData = [
                    ['nome' => 'Pinus Tratado', 'visualizacoes' => 1250],
                    ['nome' => 'Ipê para Deck', 'visualizacoes' => 890],
                    ['nome' => 'Eucalipto', 'visualizacoes' => 670],
                    ['nome' => 'Cumaru', 'visualizacoes' => 540],
                    ['nome' => 'Jatobá', 'visualizacoes' => 420]
                ];
                
                // Mesclar dados reais com dados padrão
                $result = array_merge($result, array_slice($defaultData, count($result)));
                $result = array_slice($result, 0, 5);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log('Erro ao obter top produtos: ' . $e->getMessage());
            // Retornar dados padrão em caso de erro
            return [
                ['nome' => 'Pinus Tratado', 'visualizacoes' => 1250],
                ['nome' => 'Ipê para Deck', 'visualizacoes' => 890],
                ['nome' => 'Eucalipto', 'visualizacoes' => 670],
                ['nome' => 'Cumaru', 'visualizacoes' => 540],
                ['nome' => 'Jatobá', 'visualizacoes' => 420]
            ];
        }
    }
}

