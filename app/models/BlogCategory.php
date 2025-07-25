<?php

namespace app\models;

class BlogCategory extends Model
{
    protected $table = 'blog_categories';
    
    public function getBySlug(string $slug): ?array
    {
        return $this->findBy('slug', $slug);
    }
    
    public function getAtivas(): array
    {
        return $this->all();
    }
    
    public function getComContadores(): array
    {
        try {
            $sql = "
                SELECT bc.*, COUNT(bp.id) as total_posts
                FROM {$this->table} bc
                LEFT JOIN blog_posts bp ON bc.id = bp.category_id AND bp.status = 'published'
                GROUP BY bc.id
                ORDER BY bc.name
            ";
            
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
}