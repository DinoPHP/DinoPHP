<?php

namespace Dinophp\File;

class File {
    /**
     * File Constructor
     */
    private function __construct() {}

    /**
     * Root path
     */
    public static function root() {
        return ROOT;
    }

    /**
     * Directory Separator
     */
    public static function ds() {
        return DS;
    }

    /**
     * 
     * Get file for path
     * 
     */
    public static function path($path) {
        $path = static::root() . static::ds() . trim($path, '/');
        $path = str_replace(['/', '\\'], static::ds(), $path);

        return $path;
    }

    /**
     * 
     * Check if file exists
     * 
     */
    public static function exist($path) {
        return file_exists(static::path($path));
    }

    /**
     * 
     * Require files
     * 
     */
    public static function require_file($path) {
        if (static::exist($path)) {
            return require_once static::path($path);
        }
    }

    /**
     * 
     * Include files
     * 
     */
    public static function include_file($path) {
        if (static::exist($path)) {
            return include static::path($path);
        }
    }

    /**
     * 
     * Require Directory
     * 
     */
    public static function require_dir($path) {
        $files = array_diff(scandir(static::path($path)), ['.', '..']);
        foreach ($files as $file) {
            $file_path = $path . static::ds() . $file;
            if (static::exist($file_path)) {
                static::require_file($file_path);
            }
        }
    }
}
