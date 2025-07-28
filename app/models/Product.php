<?php

namespace app\models;

class Product extends Model
{
    protected $table = 'products';
    
    public function getBySlug(string $slug): ?array
    {
        $product = $this->findBy('slug', $slug);
        return $product ? $this->transformProductData($product) : null;
    }
    
    public function getAtivos(): array
    {
        return $this->where(['is_active' => 1]);
    }
    
    public function getByCategoria(string $categoria): array
    {
        return $this->where(['category' => $categoria, 'is_active' => 1]);
    }
    
    public function getDestaques(): array
    {
        return $this->where(['is_featured' => 1, 'is_active' => 1]);
    }
    
    public function getById(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ? AND is_active = 1");
            $stmt->execute([$id]);
            $produto_db = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$produto_db) {
                return null;
            }
            
            return $this->transformProductData($produto_db);
            
        } catch (\Exception $e) {
            error_log('Error fetching product by ID: ' . $e->getMessage());
            return null;
        }
    }
    
    public function getFiltered(string $categoria = 'todos', string $aplicacao = 'todas', float $preco_min = 0, float $preco_max = 9999): array
    {
        try {
            // Build the query
            $sql = "SELECT * FROM {$this->table} WHERE is_active = 1";
            $params = [];
            
            // Add category filter
            if ($categoria !== 'todos') {
                $sql .= " AND category = ?";
                $params[] = $categoria;
            }
            
            // Add price filter
            if ($preco_min > 0 || $preco_max < 9999) {
                $sql .= " AND price_per_m3 BETWEEN ? AND ?";
                $params[] = $preco_min;
                $params[] = $preco_max;
            }
            
            $sql .= " ORDER BY is_featured DESC, name ASC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $produtos_db = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            // Transform database results to match expected format
            $produtos = [];
            foreach ($produtos_db as $produto) {
                $aplicacoes = json_decode($produto['applications'] ?? '[]', true) ?: [];
                
                // Apply application filter
                if ($aplicacao !== 'todas' && !in_array($aplicacao, $aplicacoes)) {
                    continue;
                }
                
                $produtos[] = $this->transformProductData($produto);
            }
            
            return $produtos;
            
        } catch (\Exception $e) {
            error_log('Error fetching filtered products: ' . $e->getMessage());
            return [];
        }
    }
    
    public function getRelated(string $categoria, int $excluir_id, int $limit = 3): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE category = ? AND id != ? AND is_active = 1 LIMIT ?");
            $stmt->execute([$categoria, $excluir_id, $limit]);
            $produtos_db = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            $relacionados = [];
            foreach ($produtos_db as $produto_db) {
                $relacionados[] = $this->transformProductData($produto_db);
            }
            
            return $relacionados;
            
        } catch (\Exception $e) {
            error_log('Error fetching related products: ' . $e->getMessage());
            return [];
        }
    }
    
    public function getCategorias(): array
    {
        try {
            $stmt = $this->db->prepare("SELECT DISTINCT category FROM {$this->table} WHERE is_active = 1 ORDER BY category");
            $stmt->execute();
            $categorias_db = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            
            // Add "todos" option at the beginning
            $categorias = ['todos' => 'Todas as Categorias'];
            foreach ($categorias_db as $categoria) {
                $categorias[$categoria] = ucfirst($categoria);
            }
            
            return $categorias;
            
        } catch (\Exception $e) {
            error_log('Error fetching categories: ' . $e->getMessage());
            return [
                'todos' => 'Todas as Categorias',
                'estrutural' => 'Estrutural',
                'acabamento' => 'Acabamento',
                'deck' => 'Deck e Pisos'
            ];
        }
    }
    
    public function getAplicacoes(): array
    {
        try {
            $stmt = $this->db->prepare("SELECT applications FROM {$this->table} WHERE is_active = 1 AND applications IS NOT NULL");
            $stmt->execute();
            $aplicacoes_db = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            
            $aplicacoes = ['todas' => 'Todas as Aplicações'];
            $aplicacoes_list = [];
            
            foreach ($aplicacoes_db as $aplicacao_json) {
                $aplicacao_array = json_decode($aplicacao_json, true);
                if (is_array($aplicacao_array)) {
                    foreach ($aplicacao_array as $aplicacao) {
                        if (!in_array($aplicacao, $aplicacoes_list)) {
                            $aplicacoes_list[] = $aplicacao;
                        }
                    }
                }
            }
            
            sort($aplicacoes_list);
            foreach ($aplicacoes_list as $aplicacao) {
                $aplicacoes[$aplicacao] = ucfirst(str_replace('_', ' ', $aplicacao));
            }
            
            return $aplicacoes;
            
        } catch (\Exception $e) {
            error_log('Error fetching applications: ' . $e->getMessage());
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
    
    public function transformProductData(array $produto_db): array
    {
        return [
            'id' => (int)$produto_db['id'],
            'nome' => $produto_db['name'],
            'categoria' => $produto_db['category'],
            'preco_m3' => (float)$produto_db['price_per_m3'],
            'preco_formatado' => 'R$ ' . number_format($produto_db['price_per_m3'], 0, ',', '.'),
            'aplicacoes' => json_decode($produto_db['applications'] ?? '[]', true) ?: [],
            'descricao' => $produto_db['description'],
            'descricao_completa' => $produto_db['full_description'],
            'imagem' => $produto_db['image_url'],
            'galeria' => json_decode($produto_db['gallery'] ?? '[]', true) ?: [],
            'certificacoes' => json_decode($produto_db['certifications'] ?? '[]', true) ?: [],
            'especificacoes' => json_decode($produto_db['specifications'] ?? '{}', true) ?: [],
            'disponibilidade' => $this->formatAvailability($produto_db['availability']),
            'origem' => [
                'localizacao' => $produto_db['origin_location'] ?? 'Não informado',
                'fornecedor' => $produto_db['supplier'] ?? 'Não informado'
            ]
        ];
    }
    
    private function formatAvailability(string $availability): string
    {
        $map = [
            'in_stock' => 'Em estoque',
            'low_stock' => 'Baixo estoque',
            'out_of_stock' => 'Fora de estoque',
            'on_demand' => 'Sob consulta'
        ];
        
        return $map[$availability] ?? 'Não informado';
    }
}