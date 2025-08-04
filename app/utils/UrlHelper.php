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
        $config = Flight::get('config');

        if ($config && isset($config['app']['base_path'])) {
            return rtrim($config['app']['base_path'], '/');
        }

        return '/';
    }

    /**
     * Get the full application URL from configuration
     */
    public static function getAppUrl(): string
    {
        $config = Flight::get('config');

        return $config['app']['url'] ?? '';
    }

    /**
     * Generate a URL with the correct base path
     */
    public static function url(string $path = ''): string
    {
        $config = Flight::get('app.config');
        $base_path = Flight::get('flight.base_url') ?? '/';
        $url = rtrim($config['app']['url'], '/') . '/' . ltrim($base_path, '/');

        if (empty($path)) {
            return $url;
        }

        return rtrim($config['app']['url'], '/') . '/' . ltrim($path, '/');
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
