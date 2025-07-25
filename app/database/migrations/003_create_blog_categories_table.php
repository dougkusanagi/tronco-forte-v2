<?php

namespace app\database\migrations;

use app\database\Migration;

class CreateBlogCategoriesTable extends Migration
{
    public function up(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS blog_categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) UNIQUE NOT NULL,
                description TEXT,
                color VARCHAR(7) DEFAULT '#8B4513',
                icon VARCHAR(50),
                active TINYINT(1) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";
        
        $this->execute($sql);
    }
    
    public function down(): void
    {
        $this->execute("DROP TABLE IF EXISTS blog_categories");
    }
}