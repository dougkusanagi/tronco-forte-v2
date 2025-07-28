-- SQLite-specific migration for fornecedores table
CREATE TABLE IF NOT EXISTS fornecedores (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    slug TEXT UNIQUE,
    email TEXT NOT NULL UNIQUE,
    telefone TEXT,
    endereco TEXT,
    cidade TEXT,
    estado TEXT,
    regiao TEXT,
    cep TEXT,
    cnpj TEXT UNIQUE,
    especialidade TEXT,
    especialidades TEXT,
    certificacoes TEXT,
    produtos TEXT,
    descricao TEXT,
    website TEXT,
    links TEXT,
    redes_sociais TEXT,
    verificado INTEGER NOT NULL DEFAULT 0 CHECK (verificado IN (0, 1)),
    avaliacao REAL DEFAULT 0.0,
    ativo INTEGER NOT NULL DEFAULT 1 CHECK (ativo IN (0, 1)),
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_fornecedores_nome ON fornecedores(nome);
CREATE INDEX IF NOT EXISTS idx_fornecedores_slug ON fornecedores(slug);
CREATE INDEX IF NOT EXISTS idx_fornecedores_email ON fornecedores(email);
CREATE INDEX IF NOT EXISTS idx_fornecedores_cnpj ON fornecedores(cnpj);
CREATE INDEX IF NOT EXISTS idx_fornecedores_cidade ON fornecedores(cidade);
CREATE INDEX IF NOT EXISTS idx_fornecedores_regiao ON fornecedores(regiao);
CREATE INDEX IF NOT EXISTS idx_fornecedores_especialidade ON fornecedores(especialidade);
CREATE INDEX IF NOT EXISTS idx_fornecedores_especialidades ON fornecedores(especialidades);
CREATE INDEX IF NOT EXISTS idx_fornecedores_verificado ON fornecedores(verificado);
CREATE INDEX IF NOT EXISTS idx_fornecedores_avaliacao ON fornecedores(avaliacao);
CREATE INDEX IF NOT EXISTS idx_fornecedores_ativo ON fornecedores(ativo);

-- Create trigger to update updated_at timestamp
CREATE TRIGGER IF NOT EXISTS update_fornecedores_updated_at
    AFTER UPDATE ON fornecedores
    FOR EACH ROW
BEGIN
    UPDATE fornecedores SET updated_at = datetime('now') WHERE id = NEW.id;
END;