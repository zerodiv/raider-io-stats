<?php declare(strict_types=1);

namespace RaiderIO;

class TmpDir {
    private static string $_tmp = '';
    
    public static function set(string $path) {
        self::$_tmp = $path;
        return true;
    }

    public static function get() {
        return self::$_tmp;
    }

}