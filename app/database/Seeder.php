<?php

namespace app\database;

use PDO;
use PDOException;

abstract class Seeder
{
    protected $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    abstract public function run(): void;
    
    protected function insert(string $table, array $data): bool
    {
        try {
            $columns = implode(',', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute($data);
        } catch (PDOException $e) {
            throw new \Exception("Seeder error: " . $e->getMessage());
        }
    }
    
    protected function truncate(string $table): bool
    {
        try {
            return $this->pdo->exec("TRUNCATE TABLE {$table}") !== false;
        } catch (PDOException $e) {
            throw new \Exception("Seeder error: " . $e->getMessage());
        }
    }
    
    protected function tableExists(string $tableName): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM information_schema.tables WHERE table_name = ?");
        $stmt->execute([$tableName]);
        return $stmt->fetchColumn() > 0;
    }
}