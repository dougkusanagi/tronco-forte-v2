<?php

namespace app\utils;

use Flight;
use Exception;

class UrlHelper
{
    /**
     * Get the base path for the application from configuration
     * This handles cases where the app is installed in a subdirectory
     */
    public static function getBasePath(): string
    {
        // Try to get base path from config first
        try {
            $config = Flight::get('config');
            if ($config && isset($config['app']['base_path'])) {
                return rtrim($config['app']['base_path'], '/');
            }
        } catch (Exception $e) {
            // Fallback to old method if config is not available
        }
        
        // Fallback: Get the directory part of the script name
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $scriptDir = dirname($scriptName);
        
        // If script is in root, return empty string
        if ($scriptDir === '/' || $scriptDir === '\\') {
            return '';
        }
        
        // Return the directory path with trailing slash removed
        return rtrim($scriptDir, '/');
    }
    
    /**
     * Get the full application URL from configuration
     */
    public static function getAppUrl(): string
    {
        try {
            $config = Flight::get('config');
            if ($config && isset($config['app']['url'])) {
                return rtrim($config['app']['url'], '/');
            }
        } catch (Exception $e) {
            // Fallback to detecting from server
        }
        
        // Fallback: construct from server variables
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $protocol . '://' . $host;
    }
    
    /**
     * Generate a URL with the correct base path
     */
    public static function url(string $path = ''): string
    {
        $basePath = self::getBasePath();
        $path = ltrim($path, '/');
        
        if (empty($path)) {
            return $basePath ?: '/';
        }
        
        return $basePath . '/' . $path;
    }
    
    /**
     * Check if we're on the homepage
     */
    public static function isHomepage(): bool
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $basePath = self::getBasePath();
        
        // Remove query string
        $path = strtok($requestUri, '?');
        
        return $path === $basePath || $path === $basePath . '/';
    }
}