-- SQLite-specific migration for visitors table
CREATE TABLE IF NOT EXISTS visitors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip_address TEXT NOT NULL,
    user_agent TEXT,
    page_url TEXT NOT NULL,
    referer TEXT,
    session_id TEXT,
    country TEXT,
    city TEXT,
    device_type TEXT,
    browser TEXT,
    os TEXT,
    visited_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_visitors_ip_address ON visitors(ip_address);
CREATE INDEX IF NOT EXISTS idx_visitors_session_id ON visitors(session_id);
CREATE INDEX IF NOT EXISTS idx_visitors_page_url ON visitors(page_url);
CREATE INDEX IF NOT EXISTS idx_visitors_visited_at ON visitors(visited_at);
CREATE INDEX IF NOT EXISTS idx_visitors_country ON visitors(country);
CREATE INDEX IF NOT EXISTS idx_visitors_device_type ON visitors(device_type);