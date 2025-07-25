-- SQLite-specific migration for fornecedores table
CREATE TABLE IF NOT EXISTS fornecedores (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    telefone TEXT,
    endereco TEXT,
    cidade TEXT,
    estado TEXT,
    cep TEXT,
    cnpj TEXT UNIQUE,
    especialidade TEXT,
    certificacoes TEXT,
    descricao TEXT,
    website TEXT,
    ativo INTEGER NOT NULL DEFAULT 1 CHECK (ativo IN (0, 1)),
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_fornecedores_nome ON fornecedores(nome);
CREATE INDEX IF NOT EXISTS idx_fornecedores_email ON fornecedores(email);
CREATE INDEX IF NOT EXISTS idx_fornecedores_cnpj ON fornecedores(cnpj);
CREATE INDEX IF NOT EXISTS idx_fornecedores_cidade ON fornecedores(cidade);
CREATE INDEX IF NOT EXISTS idx_fornecedores_especialidade ON fornecedores(especialidade);
CREATE INDEX IF NOT EXISTS idx_fornecedores_ativo ON fornecedores(ativo);

-- Create trigger to update updated_at timestamp
CREATE TRIGGER IF NOT EXISTS update_fornecedores_updated_at
    AFTER UPDATE ON fornecedores
    FOR EACH ROW
BEGIN
    UPDATE fornecedores SET updated_at = datetime('now') WHERE id = NEW.id;
END;