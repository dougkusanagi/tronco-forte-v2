<?php

namespace app\database;

use PDO;
use PDOException;

abstract class Migration
{
    protected $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    abstract public function up(): void;
    abstract public function down(): void;
    
    protected function execute(string $sql): bool
    {
        try {
            return $this->pdo->exec($sql) !== false;
        } catch (PDOException $e) {
            throw new \Exception("Migration error: " . $e->getMessage());
        }
    }
    
    protected function tableExists(string $tableName): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM information_schema.tables WHERE table_name = ?");
        $stmt->execute([$tableName]);
        return $stmt->fetchColumn() > 0;
    }
}