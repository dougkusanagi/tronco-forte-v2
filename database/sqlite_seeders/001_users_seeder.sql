-- SQLite-specific seeder for users table
INSERT OR IGNORE INTO users (id, username, email, password, role, created_at, updated_at) VALUES
(1, 'admin', 'admin@troncoforte.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', datetime('now'), datetime('now')),
(2, 'editor', 'editor@troncoforte.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor', datetime('now'), datetime('now')),
(3, 'user', 'user@troncoforte.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', datetime('now'), datetime('now'));