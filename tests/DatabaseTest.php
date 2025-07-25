<?php

use PHPUnit\Framework\TestCase;
use app\core\Database;

class DatabaseTest extends TestCase
{
    private $db;
    
    protected function setUp(): void
    {
        $this->db = Database::getInstance();
    }
    
    public function testUsersTableExists()
    {
        $result = $this->db->query("SHOW TABLES LIKE 'users'");
        $this->assertNotEmpty($result, 'Tabela users deve existir');
    }
    
    public function testFornecedoresTableExists()
    {
        $result = $this->db->query("SHOW TABLES LIKE 'fornecedores'");
        $this->assertNotEmpty($result, 'Tabela fornecedores deve existir');
    }
    
    public function testBlogPostsTableExists()
    {
        $result = $this->db->query("SHOW TABLES LIKE 'blog_posts'");
        $this->assertNotEmpty($result, 'Tabela blog_posts deve existir');
    }
    
    public function testBlogCategoriesTableExists()
    {
        $result = $this->db->query("SHOW TABLES LIKE 'blog_categories'");
        $this->assertNotEmpty($result, 'Tabela blog_categories deve existir');
    }
    
    public function testAdminUserExists()
    {
        $result = $this->db->query("SELECT * FROM users WHERE email = 'admin@troncoforte.com'");
        $this->assertNotEmpty($result, 'Usuário admin deve existir');
    }
    
    public function testFornecedoresHaveData()
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM fornecedores");
        $this->assertGreaterThan(0, $result[0]['count'], 'Deve haver fornecedores cadastrados');
    }
    
    public function testBlogPostsHaveData()
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM blog_posts");
        $this->assertGreaterThan(0, $result[0]['count'], 'Deve haver posts no blog');
    }
    
    public function testBlogCategoriesHaveData()
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM blog_categories");
        $this->assertGreaterThan(0, $result[0]['count'], 'Deve haver categorias no blog');
    }
}