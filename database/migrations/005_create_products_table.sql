-- Migration: Create products table
-- Created: 2024-01-01
-- Description: Tabela para armazenar produtos do catálogo

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    full_description LONGTEXT,
    category VARCHAR(100) NOT NULL,
    price_per_m3 DECIMAL(10,2) NOT NULL,
    applications TEXT, -- JSON array of applications
    image_url VARCHAR(500),
    gallery TEXT, -- JSON array of image URLs
    certifications TEXT, -- JSON array of certifications
    specifications TEXT, -- JSON object of specifications
    availability ENUM('in_stock', 'low_stock', 'out_of_stock', 'on_demand') DEFAULT 'in_stock',
    origin_location VARCHAR(255),
    supplier VARCHAR(255),
    views INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE INDEX idx_products_slug ON products(slug);
CREATE INDEX idx_products_category ON products(category);
CREATE INDEX idx_products_is_active ON products(is_active);
CREATE INDEX idx_products_is_featured ON products(is_featured);
CREATE INDEX idx_products_availability ON products(availability);
CREATE INDEX idx_products_price ON products(price_per_m3);
CREATE INDEX idx_products_views ON products(views);