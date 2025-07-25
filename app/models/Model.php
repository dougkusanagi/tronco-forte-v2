<?php

namespace app\models;

use PDO;
use PDOException;
use Flight;

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    
    public function __construct()
    {
        $this->db = Flight::db();
    }
    
    public function find(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function findBy(string $column, $value): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = ?");
            $stmt->execute([$value]);
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function all(): array
    {
        try {
            $result = $this->db->fetchAll("SELECT * FROM {$this->table}");
            return is_array($result) ? $result : $result->toArray();
        } catch (PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function where(array $conditions): array
    {
        try {
            $whereClause = [];
            $values = [];
            
            foreach ($conditions as $column => $value) {
                $whereClause[] = "{$column} = ?";
                $values[] = $value;
            }
            
            $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $whereClause);
            $result = $this->db->fetchAll($sql, $values);
            return is_array($result) ? $result : $result->toArray();
        } catch (PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function create(array $data): int
    {
        try {
            $columns = implode(',', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function update(int $id, array $data): bool
    {
        try {
            $setClause = [];
            foreach (array_keys($data) as $column) {
                $setClause[] = "{$column} = :{$column}";
            }
            
            $sql = "UPDATE {$this->table} SET " . implode(', ', $setClause) . " WHERE {$this->primaryKey} = :id";
            $data['id'] = $id;
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
}