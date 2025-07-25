<?php

namespace app\utils;

class UrlHelper
{
    /**
     * Get the base path for the application based on the current request
     * This handles cases where the app is installed in a subdirectory
     */
    public static function getBasePath(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        
        // Get the directory part of the script name
        $scriptDir = dirname($scriptName);
        
        // If script is in root, return empty string
        if ($scriptDir === '/' || $scriptDir === '\\') {
            return '';
        }
        
        // Return the directory path with trailing slash removed
        return rtrim($scriptDir, '/');
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