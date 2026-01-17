<?php
class Flash
{
    public static function set($type, $msg)
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $msg];
    }

    public static function get()
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}
