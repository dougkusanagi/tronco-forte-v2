<?php

namespace app\utils;

class ImageHelper
{
    /**
     * Check if an image file exists and return the image URL or a fallback
     *
     * @param string|null $imageUrl The image URL to check
     * @param string $fallbackType Type of fallback image (blog, product, avatar)
     * @return string The image URL or fallback URL
     */
    public static function getImageOrFallback(?string $imageUrl, string $fallbackType = 'blog'): string
    {
        // If no image URL provided, return fallback immediately
        if (empty($imageUrl)) {
            return self::getFallbackImage($fallbackType);
        }
        
        // Check if it's a relative path and convert to absolute
        if (strpos($imageUrl, 'http') !== 0) {
            $publicPath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($imageUrl, '/');
            
            // Check if file exists
            if (!file_exists($publicPath)) {
                return self::getFallbackImage($fallbackType);
            }
        }
        
        return $imageUrl;
    }
    
    /**
     * Get fallback image URL based on type
     *
     * @param string $type Type of fallback image
     * @return string Fallback image URL
     */
    private static function getFallbackImage(string $type): string
    {
        $fallbacks = [
            'blog' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=wooden%20construction%20materials%20lumber%20yard&image_size=landscape_16_9',
            'product' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=wood%20lumber%20material%20sample&image_size=square',
            'avatar' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20carpenter%20avatar%20portrait&image_size=square',
            'default' => 'https://trae-api-us.mchost.guru/api/ide/v1/text_to_image?prompt=wooden%20texture%20background&image_size=landscape_16_9'
        ];
        
        return $fallbacks[$type] ?? $fallbacks['default'];
    }
    
    /**
     * Get a placeholder image with specific dimensions
     *
     * @param int $width Image width
     * @param int $height Image height
     * @param string $text Optional text to display
     * @return string Placeholder image URL
     */
    public static function getPlaceholder(int $width = 400, int $height = 300, string $text = ''): string
    {
        $baseUrl = 'https://via.placeholder.com/';
        $dimensions = $width . 'x' . $height;
        $colors = '/8B4513/FFFFFF'; // Wood brown background with white text
        
        $url = $baseUrl . $dimensions . $colors;
        
        if (!empty($text)) {
            $url .= '?text=' . urlencode($text);
        }
        
        return $url;
    }
    
    /**
     * Check if an image URL is accessible
     *
     * @param string $imageUrl The image URL to check
     * @return bool True if accessible, false otherwise
     */
    public static function isImageAccessible(string $imageUrl): bool
    {
        // For local files
        if (strpos($imageUrl, 'http') !== 0) {
            $publicPath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($imageUrl, '/');
            return file_exists($publicPath);
        }
        
        // For remote URLs, we'll assume they're accessible to avoid performance issues
        // In a production environment, you might want to implement a more sophisticated check
        return true;
    }
}