-- Seeder: Blog categories data
-- Created: 2024-01-01
-- Description: Categorias iniciais para o blog

INSERT OR REPLACE INTO blog_categories (name, slug, description, color, is_active) VALUES
('Madeiras Sustentáveis', 'madeiras-sustentaveis', 'Artigos sobre práticas sustentáveis na indústria madeireira', '#10B981', 1),
('Técnicas e Processos', 'tecnicas-processos', 'Guias sobre técnicas de processamento e beneficiamento de madeira', '#3B82F6', 1),
('Mercado e Tendências', 'mercado-tendencias', 'Análises de mercado e tendências do setor madeireiro', '#8B5CF6', 1),
('Certificações', 'certificacoes', 'Informações sobre certificações e qualidade na indústria', '#F59E0B', 1),
('Inovação e Tecnologia', 'inovacao-tecnologia', 'Novidades tecnológicas e inovações no setor', '#EF4444', 1);