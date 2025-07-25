-- Seeder: Users data
-- Created: 2024-01-01
-- Description: Dados iniciais para usuários administradores

INSERT OR REPLACE INTO users (name, email, password, role, avatar, is_active) VALUES
('Administrador', 'admin@troncoforte.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20business%20administrator%20avatar%20corporate%20style&image_size=square', 1),
('Editor Tronco Forte', 'editor@troncoforte.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor', 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20content%20editor%20avatar%20creative%20style&image_size=square', 1);