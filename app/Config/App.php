<?php

namespace App\Config;

class App {
    const BASE_URL = 'http://localhost:8000';
    
    // Base upload directories relative to public folder
    const UPLOAD_DIR_CHARACTERS = '/uploads/characters/';
    const UPLOAD_DIR_ARCS = '/uploads/arcs/';
    const UPLOAD_DIR_ABILITIES = '/uploads/abilities/';

    public static function getPublicUploadPath(string $type): string {
        $baseDir = __DIR__ . '/../../public';
        switch ($type) {
            case 'character':
                return $baseDir . self::UPLOAD_DIR_CHARACTERS;
            case 'arc':
                return $baseDir . self::UPLOAD_DIR_ARCS;
            case 'ability':
                return $baseDir . self::UPLOAD_DIR_ABILITIES;
            default:
                return $baseDir . '/uploads/';
        }
    }
}
