-- SQLite-specific migration for products table
CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    description TEXT,
    full_description TEXT,
    category TEXT NOT NULL,
    price_per_m3 REAL NOT NULL,
    applications TEXT, -- JSON array of applications
    image_url TEXT,
    gallery TEXT, -- JSON array of image URLs
    certifications TEXT, -- JSON array of certifications
    specifications TEXT, -- JSON object of specifications
    availability TEXT NOT NULL DEFAULT 'in_stock' CHECK (availability IN ('in_stock', 'low_stock', 'out_of_stock', 'on_demand')),
    origin_location TEXT,
    supplier TEXT,
    views INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1 CHECK (is_active IN (0, 1)),
    is_featured INTEGER DEFAULT 0 CHECK (is_featured IN (0, 1)),
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_products_name ON products(name);
CREATE INDEX IF NOT EXISTS idx_products_slug ON products(slug);
CREATE INDEX IF NOT EXISTS idx_products_category ON products(category);
CREATE INDEX IF NOT EXISTS idx_products_is_active ON products(is_active);
CREATE INDEX IF NOT EXISTS idx_products_is_featured ON products(is_featured);
CREATE INDEX IF NOT EXISTS idx_products_availability ON products(availability);
CREATE INDEX IF NOT EXISTS idx_products_price ON products(price_per_m3);
CREATE INDEX IF NOT EXISTS idx_products_views ON products(views);
CREATE INDEX IF NOT EXISTS idx_products_created_at ON products(created_at);

-- Create trigger to update updated_at timestamp
CREATE TRIGGER IF NOT EXISTS update_products_updated_at
    AFTER UPDATE ON products
    FOR EACH ROW
BEGIN
    UPDATE products SET updated_at = datetime('now') WHERE id = NEW.id;
END;