-- SQLite-specific migration for blog_categories table
CREATE TABLE IF NOT EXISTS blog_categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    slug TEXT NOT NULL UNIQUE,
    description TEXT,
    active INTEGER NOT NULL DEFAULT 1 CHECK (active IN (0, 1)),
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_blog_categories_name ON blog_categories(name);
CREATE INDEX IF NOT EXISTS idx_blog_categories_slug ON blog_categories(slug);
CREATE INDEX IF NOT EXISTS idx_blog_categories_active ON blog_categories(active);

-- Create trigger to update updated_at timestamp
CREATE TRIGGER IF NOT EXISTS update_blog_categories_updated_at
    AFTER UPDATE ON blog_categories
    FOR EACH ROW
BEGIN
    UPDATE blog_categories SET updated_at = datetime('now') WHERE id = NEW.id;
END;