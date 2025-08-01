<?php

namespace app\models;

class BlogPost extends Model
{
    protected $table = 'blog_posts';
    
    public function getBySlug(string $slug): ?array
    {
        return $this->findBy('slug', $slug);
    }
    
    public function getPublicados(): array
    {
        return $this->where(['status' => 'published']);
    }
    
    public function getByCategoria(int $categoria_id): array
    {
        return $this->where(['category_id' => $categoria_id, 'status' => 'published']);
    }
    
    public function getDestaques(): array
    {
        return $this->where(['status' => 'published', 'featured' => 1]);
    }
    
    public function search(string $termo): array
    {
        try {
            $sql = "
                SELECT bp.*, bc.name as categoria_nome, bc.slug as categoria_slug
                FROM {$this->table} bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                WHERE bp.status = 'published' AND (
                    bp.title LIKE ? OR 
                    bp.excerpt LIKE ? OR 
                    bp.content LIKE ? OR
                    bp.tags LIKE ?
                )
                ORDER BY bp.created_at DESC
            ";
            
            $searchTerm = "%{$termo}%";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
            
            $result = $stmt->fetchAll();
            return is_array($result) ? $result : $result->toArray();
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function getComCategoria(): array
    {
        try {
            $sql = "
                SELECT bp.*, bc.name as categoria_nome, bc.slug as categoria_slug
                FROM {$this->table} bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                WHERE bp.status = 'published'
                ORDER BY bp.created_at DESC
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return is_array($result) ? $result : $result->toArray();
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function processarDados($post): array
    {
        // Convert Collection to array if needed
        if (is_object($post) && method_exists($post, "toArray")) {
            $post = $post->toArray();
        } elseif (!is_array($post)) {
            $post = (array) $post;
        }
        
        // Map database columns to template variables
        $post['titulo'] = $post['title'] ?? '';
        $post['resumo'] = $post['excerpt'] ?? '';
        $post['conteudo'] = $post['content'] ?? '';
        $post['imagem_destaque'] = $post['featured_image'] ?? '';
        $post['tempo_leitura'] = $post['reading_time'] ?? 5;
        $post['visualizacoes'] = $post['views'] ?? 0;
        $post['categoria'] = $post['categoria_nome'] ?? 'Geral';
        $post['slug'] = $post['slug'] ?? '';
        
        // Decodificar campos JSON
        if (isset($post['tags'])) {
            $post['tags'] = json_decode($post['tags'], true) ?: [];
        } else {
            $post['tags'] = [];
        }
        
        // Create author data structure
        $post['autor'] = [
            'nome' => 'Especialista Tronco Forte',
            'cargo' => 'Especialista em Madeira',
            'avatar' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20carpenter%20avatar%20portrait&image_size=square'
        ];
        
        // Formatar data
        $dateField = $post['published_at'] ?? $post['created_at'] ?? null;
        if ($dateField) {
            $date = new \DateTime($dateField);
            $post['data_formatada'] = $date->format('d \\d\\e F, Y');
            $post['data_publicacao'] = $date->format('Y-m-d');
        } else {
            $post['data_formatada'] = date('d \\d\\e F, Y');
            $post['data_publicacao'] = date('Y-m-d');
        }
        
        return $post;
    }
}

