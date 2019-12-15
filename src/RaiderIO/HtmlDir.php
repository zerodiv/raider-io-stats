<?php declare(strict_types=1);

namespace RaiderIO;

class HtmlDir
{
    private static string $_dir = '';
    
    public static function set(string $path)
    {
        self::$_dir = $path;
        return true;
    }

    public static function get()
    {
        return self::$_dir;
    }
}
