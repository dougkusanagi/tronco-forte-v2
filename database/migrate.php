<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/database/Database.php';

use app\database\Database;

class DatabaseMigrator
{
    private $db;
    private $migrationsPath;
    private $seedersPath;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->migrationsPath = __DIR__ . '/migrations';
        $this->seedersPath = __DIR__ . '/seeders';
        
        // Criar tabela de controle de migrations se não existir
        $this->createMigrationsTable();
    }
    
    private function createMigrationsTable()
    {
        $config = require __DIR__ . '/../app/config/config.php';
        $dbType = $config['database']['type'] ?? 'sqlite';
        
        if ($dbType === 'mysql') {
            $sql = "
                CREATE TABLE IF NOT EXISTS migrations (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    migration VARCHAR(255) NOT NULL UNIQUE,
                    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ";
        } else {
            $sql = "
                CREATE TABLE IF NOT EXISTS migrations (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    migration TEXT NOT NULL UNIQUE,
                    executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            ";
        }
        
        $this->db->query($sql);
        echo "✓ Tabela de controle de migrations criada\n";
    }
    
    public function runMigrations()
    {
        echo "\n=== Executando Migrations ===\n";
        
        $files = glob($this->migrationsPath . '/*.sql');
        sort($files);
        
        foreach ($files as $file) {
            $migrationName = basename($file);
            
            // Verificar se já foi executada
            $result = $this->db->query(
                "SELECT id FROM migrations WHERE migration = ?",
                [$migrationName]
            );
            
            if (empty($result)) {
                echo "Executando: {$migrationName}...";
                
                try {
                    $sql = file_get_contents($file);
                    $statements = array_filter(array_map('trim', explode(';', $sql)));
                    foreach ($statements as $stmt) {
                        if (!empty($stmt)) {
                            $this->db->query($stmt);
                        }
                    }
                    
                    // Registrar como executada
                    $this->db->query(
                        "INSERT INTO migrations (migration) VALUES (?)",
                        [$migrationName]
                    );
                    
                    echo " ✓\n";
                } catch (Exception $e) {
                    echo " ✗ Erro: " . $e->getMessage() . "\n";
                }
            } else {
                echo "Pulando: {$migrationName} (já executada)\n";
            }
        }
    }
    
    public function runSeeders()
    {
        echo "\n=== Executando Seeders ===\n";
        
        $files = glob($this->seedersPath . '/*.sql');
        sort($files);
        
        foreach ($files as $file) {
            $seederName = basename($file);
            echo "Executando: {$seederName}...";
            
            try {
                $sql = file_get_contents($file);
                $statements = array_filter(array_map('trim', explode(';', $sql)));
                foreach ($statements as $stmt) {
                    if (!empty($stmt)) {
                        $this->db->query($stmt);
                    }
                }
                echo " ✓\n";
            } catch (Exception $e) {
                echo " ✗ Erro: " . $e->getMessage() . "\n";
            }
        }
    }
    
    public function runTests()
    {
        echo "\n=== Executando Testes ===\n";
        
        // Verificar se as tabelas existem
        $tables = ['users', 'fornecedores', 'blog_categories', 'blog_posts'];
        
        foreach ($tables as $table) {
            $result = $this->db->query("SELECT TABLE_NAME FROM information_schema.tables WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?", [$table]);
            if (!empty($result)) {
                echo "✓ Tabela '{$table}' existe\n";
            } else {
                echo "✗ Tabela '{$table}' não encontrada\n";
            }
        }
        
        // Verificar se há dados
        $dataChecks = [
            'users' => 'Usuários',
            'fornecedores' => 'Fornecedores',
            'blog_categories' => 'Categorias do blog',
            'blog_posts' => 'Posts do blog'
        ];
        
        foreach ($dataChecks as $table => $description) {
            $result = $this->db->query("SELECT COUNT(*) as count FROM {$table}");
            $count = $result[0]['count'] ?? 0;
            
            if ($count > 0) {
                echo "✓ {$description}: {$count} registros\n";
            } else {
                echo "✗ {$description}: nenhum registro encontrado\n";
            }
        }
    }
}

// Executar se chamado diretamente
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    $migrator = new DatabaseMigrator();
    
    echo "Tronco Forte - Database Migrator\n";
    echo "================================\n";
    
    $migrator->runMigrations();
    $migrator->runSeeders();
    $migrator->runTests();
    
    echo "\n=== Concluído ===\n";
}