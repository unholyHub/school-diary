<?php

namespace App\Helpers;

class JavaScriptManager
{
    private static $scripts = [];

    public static function addScript($src)
    {
        $src = "public/assets/js/" . $src;
        self::$scripts[] = $src;
    }

    public static function getScripts()
    {
        return self::$scripts;
    }
}
