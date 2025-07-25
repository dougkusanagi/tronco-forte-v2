-- Migration: Create fornecedores table
-- Created: 2024-01-01
-- Description: Tabela para armazenar dados dos fornecedores parceiros

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
);

CREATE INDEX IF NOT EXISTS idx_fornecedores_slug ON fornecedores(slug);
CREATE INDEX IF NOT EXISTS idx_fornecedores_regiao ON fornecedores(regiao);
CREATE INDEX IF NOT EXISTS idx_fornecedores_cidade ON fornecedores(cidade);
CREATE INDEX IF NOT EXISTS idx_fornecedores_is_ativo ON fornecedores(is_ativo);
CREATE INDEX IF NOT EXISTS idx_fornecedores_is_verificado ON fornecedores(is_verificado);
CREATE INDEX IF NOT EXISTS idx_fornecedores_avaliacao ON fornecedores(avaliacao);