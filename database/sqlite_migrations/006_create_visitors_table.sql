-- SQLite-specific migration for visitors table
CREATE TABLE IF NOT EXISTS visitors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip_address TEXT NOT NULL,
    user_agent TEXT,
    page_url TEXT NOT NULL,
    referrer TEXT,
    session_id TEXT,
    country TEXT,
    city TEXT,
    device_type TEXT,
    browser TEXT,
    os TEXT,
    is_unique INTEGER NOT NULL DEFAULT 0 CHECK (is_unique IN (0, 1)),
    visited_at TEXT NOT NULL DEFAULT (datetime('now')),
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_visitors_ip_address ON visitors(ip_address);
CREATE INDEX IF NOT EXISTS idx_visitors_session_id ON visitors(session_id);
CREATE INDEX IF NOT EXISTS idx_visitors_page_url ON visitors(page_url);
CREATE INDEX IF NOT EXISTS idx_visitors_visited_at ON visitors(visited_at);
CREATE INDEX IF NOT EXISTS idx_visitors_created_at ON visitors(created_at);
CREATE INDEX IF NOT EXISTS idx_visitors_country ON visitors(country);
CREATE INDEX IF NOT EXISTS idx_visitors_device_type ON visitors(device_type);
CREATE INDEX IF NOT EXISTS idx_visitors_is_unique ON visitors(is_unique);

-- Create trigger to update updated_at timestamp
CREATE TRIGGER IF NOT EXISTS update_visitors_updated_at
    AFTER UPDATE ON visitors
    FOR EACH ROW
BEGIN
    UPDATE visitors SET updated_at = datetime('now') WHERE id = NEW.id;
END;