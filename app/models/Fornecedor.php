<?php

namespace app\models;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    
    public function getBySlug(string $slug): ?array
    {
        return $this->findBy('slug', $slug);
    }
    
    public function getAtivos(string $regiao = 'todas', string $especialidade = 'todas'): array
    {
        try {
            $conditions = ['ativo = 1'];
            $params = [];
            
            if ($regiao !== 'todas') {
                $conditions[] = 'regiao = ?';
                $params[] = $regiao;
            }
            
            if ($especialidade !== 'todas') {
                $conditions[] = 'especialidades LIKE ?';
                $params[] = '%' . $especialidade . '%';
            }
            
            $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $conditions) . " ORDER BY avaliacao DESC";
            
            return $this->db->fetchAll($sql, $params);
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function getDestaques(): array
    {
        return $this->where(['ativo' => 1, 'verificado' => 1]);
    }
    
    public function getByRegiao(string $regiao): array
    {
        return $this->where(['ativo' => 1, 'regiao' => $regiao]);
    }
    
    public function search(string $termo): array
    {
        try {
            $sql = "
                SELECT * FROM {$this->table} 
                WHERE ativo = 1 AND (
                    nome LIKE ? OR 
                    descricao LIKE ? OR 
                    especialidades LIKE ? OR
                    cidade LIKE ?
                )
                ORDER BY verificado DESC, avaliacao DESC
            ";
            
            $searchTerm = "%{$termo}%";
            return $this->db->fetchAll($sql, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function getRegioes(): array
    {
        try {
            $rows = $this->db->fetchAll("
                SELECT DISTINCT regiao 
                FROM {$this->table} 
                WHERE ativo = 1 AND regiao IS NOT NULL
                ORDER BY regiao
            ");
            
            $regioes = [];
            foreach ($rows as $row) {
                $regioes[$row['regiao']] = ucfirst($row['regiao']);
            }
            
            return $regioes;
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function getEspecialidades(): array
    {
        try {
            $rows = $this->db->fetchAll("
                SELECT especialidades 
                FROM {$this->table} 
                WHERE ativo = 1 AND especialidades IS NOT NULL
            ");
            
            $especialidades = [];
            foreach ($rows as $row) {
                $fornecedorEspecialidades = json_decode($row['especialidades'], true);
                if (is_array($fornecedorEspecialidades)) {
                    foreach ($fornecedorEspecialidades as $especialidade) {
                        $key = strtolower(str_replace(' ', '_', $especialidade));
                        $especialidades[$key] = $especialidade;
                    }
                }
            }
            
            ksort($especialidades);
            return $especialidades;
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function filtrar(array $filtros): array
    {
        try {
            $conditions = ['ativo = 1'];
            $params = [];
            
            if (!empty($filtros['regiao'])) {
                $conditions[] = 'regiao = ?';
                $params[] = $filtros['regiao'];
            }
            
            if (!empty($filtros['especialidade'])) {
                $conditions[] = 'especialidades LIKE ?';
                $params[] = '%' . $filtros['especialidade'] . '%';
            }
            
            if (!empty($filtros['busca'])) {
                $conditions[] = '(nome LIKE ? OR descricao LIKE ?)';
                $searchTerm = '%' . $filtros['busca'] . '%';
                $params[] = $searchTerm;
                $params[] = $searchTerm;
            }
            
            $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $conditions) . " ORDER BY verificado DESC, avaliacao DESC";
            
            return $this->db->fetchAll($sql, $params);
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }
    
    public function processarDados($fornecedor): array
    {
        // Convert Collection to array if needed
        if (is_object($fornecedor) && method_exists($fornecedor, 'getData')) {
            $fornecedor = $fornecedor->getData();
        } elseif (is_object($fornecedor) && method_exists($fornecedor, 'toArray')) {
            $fornecedor = $fornecedor->toArray();
        } elseif (is_object($fornecedor)) {
            $fornecedor = (array) $fornecedor;
        }
        
        // Decodificar campos JSON
        if (isset($fornecedor['especialidades'])) {
            $fornecedor['especialidades'] = json_decode($fornecedor['especialidades'], true) ?: [];
        }
        
        if (isset($fornecedor['certificacoes'])) {
            $fornecedor['certificacoes'] = json_decode($fornecedor['certificacoes'], true) ?: [];
        }
        
        if (isset($fornecedor['produtos'])) {
            $fornecedor['produtos'] = json_decode($fornecedor['produtos'], true) ?: [];
        }
        
        if (isset($fornecedor['links'])) {
            $fornecedor['links'] = json_decode($fornecedor['links'], true) ?: [];
        }
        
        if (isset($fornecedor['redes_sociais'])) {
            $fornecedor['redes_sociais'] = json_decode($fornecedor['redes_sociais'], true) ?: [];
        }
        
        return $fornecedor;
    }
}