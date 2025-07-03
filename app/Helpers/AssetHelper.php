<?php

namespace App\Helpers;

class AssetHelper
{
    /**
     * Get logo asset with fallback
     *
     * @param string $type (brand, icon, etc.)
     * @param string $variant (light, dark, etc.)
     * @return string
     */
    public static function logo($type = 'brand', $variant = null)
    {
        $filename = 'logo';
        if ($variant) {
            $filename .= '-' . $variant;
        }
        $filename .= '.jpeg';

        $path = "images/{$type}/{$filename}";
        $fullPath = public_path($path);

        // Check if file exists, return path or fallback
        if (file_exists($fullPath)) {
            return asset($path);
        }

        // Fallback to default logo or return null
        $fallbackPath = "images/brand/logo.jpeg";
        if (file_exists(public_path($fallbackPath))) {
            return asset($fallbackPath);
        }

        return null;
    }

    /**
     * Get favicon
     *
     * @return string
     */
    public static function favicon()
    {
        $paths = [
            'images/icons/favicon.ico',
            'images/brand/favicon.ico',
            'favicon.ico'
        ];

        foreach ($paths as $path) {
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return asset('favicon.ico'); // Laravel default
    }

    /**
     * Check if asset exists
     *
     * @param string $path
     * @return bool
     */
    public static function exists($path)
    {
        return file_exists(public_path($path));
    }
}
