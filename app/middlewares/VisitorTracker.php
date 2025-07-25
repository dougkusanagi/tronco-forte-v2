<?php

namespace app\middlewares;

use app\models\Visitor;
use Flight;

class VisitorTracker
{
    private $visitorModel;
    
    public function __construct()
    {
        $this->visitorModel = new Visitor();
    }
    
    /**
     * Track visitor before processing request
     */
    public function before(): void
    {
        try {
            // Skip tracking for admin pages, API calls, and static assets
            $requestUri = $_SERVER['REQUEST_URI'] ?? '';
            
            if ($this->shouldSkipTracking($requestUri)) {
                return;
            }
            
            // Get visitor data
            $visitorData = $this->getVisitorData();
            
            // Track the visitor
            $this->visitorModel->track($visitorData);
            
        } catch (\Exception $e) {
            // Log error but don't break the application
            error_log('Visitor tracking error: ' . $e->getMessage());
        }
    }
    
    /**
     * Check if tracking should be skipped for this request
     */
    private function shouldSkipTracking(string $uri): bool
    {
        $skipPatterns = [
            '/admin/',
            '/api/',
            '.css',
            '.js',
            '.png',
            '.jpg',
            '.jpeg',
            '.gif',
            '.svg',
            '.ico',
            '.woff',
            '.woff2',
            '.ttf',
            '.eot',
            '/favicon.ico',
            '/robots.txt',
            '/sitemap.xml'
        ];
        
        foreach ($skipPatterns as $pattern) {
            if (strpos($uri, $pattern) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get visitor data from request
     */
    private function getVisitorData(): array
    {
        return [
            'ip_address' => $this->getClientIp(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'page_url' => $this->getCurrentUrl(),
            'referrer' => $_SERVER['HTTP_REFERER'] ?? null,
            'country' => $this->getCountryFromIp($this->getClientIp()),
            'city' => null // Could be implemented with IP geolocation service
        ];
    }
    
    /**
     * Get client IP address
     */
    private function getClientIp(): string
    {
        // Check for various headers that might contain the real IP
        $headers = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',            // Proxy
            'HTTP_X_FORWARDED_FOR',      // Load balancer/proxy
            'HTTP_X_FORWARDED',          // Proxy
            'HTTP_X_CLUSTER_CLIENT_IP',  // Cluster
            'HTTP_FORWARDED_FOR',        // Proxy
            'HTTP_FORWARDED',            // Proxy
            'REMOTE_ADDR'                // Standard
        ];
        
        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                $ip = trim($ips[0]);
                
                // Validate IP
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        
        // Fallback to REMOTE_ADDR even if it's private/reserved
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }
    
    /**
     * Get current URL
     */
    private function getCurrentUrl(): string
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        return $protocol . '://' . $host . $uri;
    }
    
    /**
     * Get country from IP (basic implementation)
     * In production, you might want to use a proper geolocation service
     */
    private function getCountryFromIp(string $ip): ?string
    {
        // For localhost/private IPs, return null
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return null;
        }
        
        // Basic country detection (you can implement a proper service here)
        // For now, return null - can be enhanced with services like MaxMind GeoIP
        return null;
    }
    
    /**
     * Static method to register middleware
     */
    public static function register(): void
    {
        $tracker = new self();
        Flight::before('start', [$tracker, 'before']);
    }
}