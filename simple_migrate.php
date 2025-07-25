<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/database/Database.php';

use app\database\Database;

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    
    echo "Creating database tables...\n";
    
    // Create users table
    $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'editor') DEFAULT 'admin',
            avatar VARCHAR(500),
            is_active TINYINT(1) DEFAULT 1,
            last_login TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($sql);
    echo "✓ Users table created\n";
    
    // Create indexes for users
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_users_email ON users(email)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_users_role ON users(role)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_users_is_active ON users(is_active)");
    echo "✓ Users indexes created\n";
    
    // Create fornecedores table
    $sql = "
        CREATE TABLE IF NOT EXISTS fornecedores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            descricao TEXT,
            email VARCHAR(255),
            telefone VARCHAR(20),
            whatsapp VARCHAR(20),
            website VARCHAR(500),
            endereco TEXT,
            cidade VARCHAR(100),
            estado VARCHAR(50),
            cep VARCHAR(10),
            regiao ENUM('norte', 'nordeste', 'centro-oeste', 'sudeste', 'sul') NOT NULL,
            especialidades TEXT,
            certificacoes TEXT,
            imagem VARCHAR(500),
            banner VARCHAR(500),
            avaliacao DECIMAL(3,2) DEFAULT 5.0,
            total_avaliacoes INT DEFAULT 0,
            total_cliques INT DEFAULT 0,
            links TEXT,
            redes_sociais TEXT,
            horario_funcionamento TEXT,
            observacoes TEXT,
            is_ativo TINYINT(1) DEFAULT 1,
            is_verificado TINYINT(1) DEFAULT 0,
            data_verificacao TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($sql);
    echo "✓ Fornecedores table created\n";
    
    // Create indexes for fornecedores
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_fornecedores_slug ON fornecedores(slug)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_fornecedores_regiao ON fornecedores(regiao)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_fornecedores_cidade ON fornecedores(cidade)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_fornecedores_is_ativo ON fornecedores(is_ativo)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_fornecedores_is_verificado ON fornecedores(is_verificado)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_fornecedores_avaliacao ON fornecedores(avaliacao)");
    echo "✓ Fornecedores indexes created\n";
    
    // Create blog_categories table
    $sql = "
        CREATE TABLE IF NOT EXISTS blog_categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            description TEXT,
            color VARCHAR(7) DEFAULT '#3B82F6',
            is_active TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($sql);
    echo "✓ Blog categories table created\n";
    
    // Create indexes for blog_categories
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_blog_categories_slug ON blog_categories(slug)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_blog_categories_is_active ON blog_categories(is_active)");
    echo "✓ Blog categories indexes created\n";
    
    // Create blog_posts table
    $sql = "
        CREATE TABLE IF NOT EXISTS blog_posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            excerpt TEXT,
            content LONGTEXT NOT NULL,
            featured_image VARCHAR(500),
            category_id INT,
            author_id INT DEFAULT 1,
            status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
            featured TINYINT(1) DEFAULT 0,
            views INT DEFAULT 0,
            published_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES blog_categories(id),
            FOREIGN KEY (author_id) REFERENCES users(id)
        )
    ";
    $pdo->exec($sql);
    echo "✓ Blog posts table created\n";
    
    // Create indexes for blog_posts
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_blog_posts_slug ON blog_posts(slug)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_blog_posts_category_id ON blog_posts(category_id)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_blog_posts_author_id ON blog_posts(author_id)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_blog_posts_status ON blog_posts(status)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_blog_posts_featured ON blog_posts(featured)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_blog_posts_published_at ON blog_posts(published_at)");
    echo "✓ Blog posts indexes created\n";
    
    // Create visitors table
    $sql = "
        CREATE TABLE IF NOT EXISTS visitors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip_address VARCHAR(45) NOT NULL,
            user_agent TEXT,
            page_url VARCHAR(500) NOT NULL,
            referrer VARCHAR(500),
            session_id VARCHAR(255),
            country VARCHAR(100),
            city VARCHAR(100),
            device_type ENUM('desktop', 'mobile', 'tablet') DEFAULT 'desktop',
            browser VARCHAR(100),
            os VARCHAR(100),
            is_unique TINYINT(1) DEFAULT 1,
            visit_duration INT DEFAULT 0,
            pages_viewed INT DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($sql);
    echo "✓ Visitors table created\n";
    
    // Create indexes for visitors
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_visitors_ip ON visitors(ip_address)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_visitors_session ON visitors(session_id)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_visitors_page_url ON visitors(page_url)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_visitors_created_at ON visitors(created_at)");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_visitors_is_unique ON visitors(is_unique)");
    echo "✓ Visitors indexes created\n";
    
    // Create daily visitors summary table
    $sql = "
        CREATE TABLE IF NOT EXISTS daily_visitors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            date DATE NOT NULL UNIQUE,
            total_visits INT DEFAULT 0,
            unique_visits INT DEFAULT 0,
            page_views INT DEFAULT 0,
            bounce_rate DECIMAL(5,2) DEFAULT 0.00,
            avg_session_duration INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($sql);
    echo "✓ Daily visitors table created\n";
    
    // Create index for daily visitors
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_daily_visitors_date ON daily_visitors(date)");
    echo "✓ Daily visitors indexes created\n";
    
    echo "\n✅ All tables created successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}