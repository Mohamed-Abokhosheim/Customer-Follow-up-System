<?php
class Auth
{
    public static function login($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['lang'] = $user['lang_pref'];
    }

    public static function logout()
    {
        session_destroy();
        header('Location: index.php?route=login');
        exit;
    }

    public static function check()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }
    }

    public static function adminOnly()
    {
        self::check();
        if ($_SESSION['user_role'] !== 'admin') {
            die(__('unauthorized'));
        }
    }

    public static function user()
    {
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'name' => $_SESSION['user_name'] ?? '',
            'role' => $_SESSION['user_role'] ?? '',
        ];
    }
}
