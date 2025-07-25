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
        $sql = "
            CREATE TABLE IF NOT EXISTS migrations (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                migration TEXT NOT NULL UNIQUE,
                executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ";
        
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
                    $this->db->query($sql);
                    
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
                $this->db->query($sql);
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
            $result = $this->db->query("SELECT name FROM sqlite_master WHERE type='table' AND name=?", [$table]);
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