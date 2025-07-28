<?php

namespace app\models;

class Visitor extends Model
{
    protected $table = 'visitors';
    
    /**
     * Track a visitor
     */
    public function track(array $data): bool
    {
        try {
            // Check if this is a unique visitor (same IP in last 24 hours)
            $isUnique = $this->isUniqueVisitor($data['ip_address']);
            
            // Get or create session
            $sessionId = $this->getOrCreateSession($data['ip_address'], $data['user_agent']);
            
            // Parse user agent for device info
            $deviceInfo = $this->parseUserAgent($data['user_agent']);
            
            $visitorData = [
                'ip_address' => $data['ip_address'],
                'user_agent' => $data['user_agent'],
                'page_url' => $data['page_url'],
                'referrer' => $data['referrer'] ?? null,
                'session_id' => $sessionId,
                'country' => $data['country'] ?? null,
                'city' => $data['city'] ?? null,
                'device_type' => $deviceInfo['device_type'],
                'browser' => $deviceInfo['browser'],
                'os' => $deviceInfo['os'],
                'is_unique' => $isUnique ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->create($visitorData);
            
            // Update daily statistics
            $this->updateDailyStats();
            
            return true;
        } catch (\Exception $e) {
            error_log('Error tracking visitor: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if visitor is unique (not seen in last 24 hours)
     */
    private function isUniqueVisitor(string $ipAddress): bool
    {
        try {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE ip_address = ? AND created_at > datetime('now', '-24 hours')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$ipAddress]);
            return $stmt->fetchColumn() == 0;
        } catch (\Exception $e) {
            return true; // Default to unique if error
        }
    }
    
    /**
     * Get or create session ID
     */
    private function getOrCreateSession(string $ipAddress, string $userAgent): string
    {
        // Check for existing session in last 30 minutes
        try {
            $sql = "SELECT session_id FROM {$this->table} 
                   WHERE ip_address = ? AND user_agent = ? 
                   AND created_at > datetime('now', '-30 minutes') 
                   ORDER BY created_at DESC LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$ipAddress, $userAgent]);
            $result = $stmt->fetchColumn();
            
            if ($result) {
                return $result;
            }
        } catch (\Exception $e) {
            // Continue to create new session
        }
        
        // Create new session ID
        return uniqid('sess_', true);
    }
    
    /**
     * Parse user agent for device information
     */
    private function parseUserAgent(string $userAgent): array
    {
        $deviceType = 'desktop';
        $browser = 'Unknown';
        $os = 'Unknown';
        
        // Detect device type
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            if (preg_match('/iPad/', $userAgent)) {
                $deviceType = 'tablet';
            } else {
                $deviceType = 'mobile';
            }
        }
        
        // Detect browser
        if (preg_match('/Chrome\/([0-9.]+)/', $userAgent, $matches)) {
            $browser = 'Chrome ' . $matches[1];
        } elseif (preg_match('/Firefox\/([0-9.]+)/', $userAgent, $matches)) {
            $browser = 'Firefox ' . $matches[1];
        } elseif (preg_match('/Safari\/([0-9.]+)/', $userAgent, $matches)) {
            $browser = 'Safari ' . $matches[1];
        } elseif (preg_match('/Edge\/([0-9.]+)/', $userAgent, $matches)) {
            $browser = 'Edge ' . $matches[1];
        }
        
        // Detect OS
        if (preg_match('/Windows NT ([0-9.]+)/', $userAgent, $matches)) {
            $os = 'Windows ' . $matches[1];
        } elseif (preg_match('/Mac OS X ([0-9._]+)/', $userAgent, $matches)) {
            $os = 'macOS ' . str_replace('_', '.', $matches[1]);
        } elseif (preg_match('/Linux/', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android ([0-9.]+)/', $userAgent, $matches)) {
            $os = 'Android ' . $matches[1];
        } elseif (preg_match('/iPhone OS ([0-9._]+)/', $userAgent, $matches)) {
            $os = 'iOS ' . str_replace('_', '.', $matches[1]);
        }
        
        return [
            'device_type' => $deviceType,
            'browser' => $browser,
            'os' => $os
        ];
    }
    
    /**
     * Update daily statistics
     */
    private function updateDailyStats(): void
    {
        try {
            $today = date('Y-m-d');
            
            // Get today's stats
            $sql = "SELECT 
                       COUNT(*) as total_visits,
                       COUNT(DISTINCT CASE WHEN is_unique = 1 THEN ip_address END) as unique_visits,
                       COUNT(*) as page_views
                   FROM {$this->table} 
                   WHERE date(created_at) = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$today]);
            $stats = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            // Check if daily_visitors table exists, if not skip this operation
            $checkTable = "SELECT name FROM sqlite_master WHERE type='table' AND name='daily_visitors'";
            $tableExists = $this->db->query($checkTable)->fetchColumn();
            
            if (!$tableExists) {
                return; // Skip if table doesn't exist
            }
            
            // SQLite-compatible upsert using INSERT OR REPLACE
            $sql = "INSERT OR REPLACE INTO daily_visitors (date, total_visits, unique_visits, page_views, updated_at) 
                   VALUES (?, ?, ?, ?, datetime('now'))";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $today,
                $stats['total_visits'],
                $stats['unique_visits'],
                $stats['page_views']
            ]);
        } catch (\Exception $e) {
            error_log('Error updating daily stats: ' . $e->getMessage());
        }
    }
    
    /**
     * Get visitor statistics
     */
    public function getStats(int $days = 30): array
    {
        try {
            $sql = "SELECT 
                       date(created_at) as date,
                       COUNT(*) as total_visits,
                       COUNT(DISTINCT ip_address) as unique_visits,
                       COUNT(DISTINCT session_id) as sessions
                   FROM {$this->table} 
                   WHERE created_at >= datetime('now', '-' || ? || ' days')
                   GROUP BY date(created_at)
                   ORDER BY date DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$days]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log('Error getting visitor stats: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get total visitors count
     */
    public function getTotalVisitors(): int
    {
        try {
            $sql = "SELECT COUNT(DISTINCT ip_address) FROM {$this->table}";
            $stmt = $this->db->query($sql);
            return (int) $stmt->fetchColumn();
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get today's visitors
     */
    public function getTodayVisitors(): array
    {
        try {
            $sql = "SELECT 
                       COUNT(*) as total_visits,
                       COUNT(DISTINCT ip_address) as unique_visits,
                       COUNT(DISTINCT session_id) as sessions
                   FROM {$this->table} 
                   WHERE date(created_at) = date('now')";
            
            $stmt = $this->db->query($sql);
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [
                'total_visits' => 0,
                'unique_visits' => 0,
                'sessions' => 0
            ];
        } catch (\Exception $e) {
            return [
                'total_visits' => 0,
                'unique_visits' => 0,
                'sessions' => 0
            ];
        }
    }
    
    /**
     * Get popular pages
     */
    public function getPopularPages(int $limit = 10): array
    {
        try {
            $sql = "SELECT 
                       page_url,
                       COUNT(*) as visits,
                       COUNT(DISTINCT ip_address) as unique_visitors
                   FROM {$this->table} 
                   WHERE created_at >= datetime('now', '-30 days')
                   GROUP BY page_url
                   ORDER BY visits DESC
                   LIMIT ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return [];
        }
    }
}