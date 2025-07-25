<?php

namespace app\database\migrations;

use app\database\Migration;

class CreateBlogPostsTable extends Migration
{
    public function up(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS blog_posts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) UNIQUE NOT NULL,
                excerpt TEXT,
                content LONGTEXT NOT NULL,
                featured_image VARCHAR(255),
                category_id INT,
                author_id INT,
                status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
                is_published TINYINT(1) DEFAULT 0,
                featured TINYINT(1) DEFAULT 0,
                views INT DEFAULT 0,
                reading_time INT DEFAULT 5,
                meta_title VARCHAR(255),
                meta_description TEXT,
                tags JSON,
                published_at TIMESTAMP NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES blog_categories(id),
                FOREIGN KEY (author_id) REFERENCES users(id)
            )
        ";
        
        $this->execute($sql);
    }
    
    public function down(): void
    {
        $this->execute("DROP TABLE IF EXISTS blog_posts");
    }
}