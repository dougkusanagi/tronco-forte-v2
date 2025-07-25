<?php

namespace app\database\migrations;

use app\database\Migration;

class CreateFornecedoresTable extends Migration
{
    public function up(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS fornecedores (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                slug VARCHAR(255) UNIQUE NOT NULL,
                descricao TEXT,
                email VARCHAR(255),
                telefone VARCHAR(50),
                whatsapp VARCHAR(50),
                website VARCHAR(255),
                endereco TEXT,
                cidade VARCHAR(100),
                estado VARCHAR(50),
                cep VARCHAR(20),
                regiao VARCHAR(50),
                cnpj VARCHAR(20),
                inscricao_estadual VARCHAR(50),
                especialidades JSON,
                certificacoes JSON,
                produtos JSON,
                imagem VARCHAR(255),
                banner VARCHAR(255),
                avaliacao DECIMAL(2,1) DEFAULT 0,
                total_avaliacoes INT DEFAULT 0,
                ativo TINYINT(1) DEFAULT 1,
                verificado TINYINT(1) DEFAULT 0,
                destaque TINYINT(1) DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";
        
        $this->execute($sql);
    }
    
    public function down(): void
    {
        $this->execute("DROP TABLE IF EXISTS fornecedores");
    }
}