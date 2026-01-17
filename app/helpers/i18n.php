<?php
class I18n
{
    private static $lang = 'en';
    private static $translations = [];

    public static function init($langPref = 'en')
    {
        self::$lang = (isset($_SESSION['lang']) && in_array($_SESSION['lang'], ['en', 'ar'])) ? $_SESSION['lang'] : $langPref;
        $path = __DIR__ . "/../lang/" . self::$lang . ".php";
        if (file_exists($path)) {
            self::$translations = include $path;
        }
    }

    public static function t($key)
    {
        return self::$translations[$key] ?? $key;
    }

    public static function getLang()
    {
        return self::$lang;
    }

    public static function isRtl()
    {
        return self::$lang === 'ar';
    }

    public static function setLang($lang)
    {
        if (in_array($lang, ['en', 'ar'])) {
            $_SESSION['lang'] = $lang;
            self::init($lang);
        }
    }
}

function __($key)
{
    return I18n::t($key);
}
