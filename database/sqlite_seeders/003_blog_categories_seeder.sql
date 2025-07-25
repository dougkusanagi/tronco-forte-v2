-- SQLite-specific seeder for blog_categories table
INSERT OR IGNORE INTO blog_categories (id, name, slug, description, active, created_at, updated_at) VALUES
(1, 'Sustentabilidade', 'sustentabilidade', 'Artigos sobre práticas sustentáveis na indústria madeireira', 1, datetime('now'), datetime('now')),
(2, 'Construção Civil', 'construcao-civil', 'Dicas e tendências para uso de madeira na construção civil', 1, datetime('now'), datetime('now')),
(3, 'Marcenaria', 'marcenaria', 'Técnicas e projetos de marcenaria com diferentes tipos de madeira', 1, datetime('now'), datetime('now')),
(4, 'Certificações', 'certificacoes', 'Informações sobre certificações florestais e ambientais', 1, datetime('now'), datetime('now')),
(5, 'Mercado', 'mercado', 'Análises e tendências do mercado madeireiro', 1, datetime('now'), datetime('now')),
(6, 'Tecnologia', 'tecnologia', 'Inovações tecnológicas na indústria da madeira', 1, datetime('now'), datetime('now'));