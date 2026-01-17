<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new UserModel();
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password']) && $user['status'] === 'active') {
                Auth::login($user);
                header('Location: index.php?route=dashboard');
                exit;
            } else {
                $error = "Invalid username or password";
                include __DIR__ . '/../views/login.php';
            }
        } else {
            include __DIR__ . '/../views/login.php';
        }
    }

    public function logout()
    {
        Auth::logout();
    }

    public function setLang()
    {
        $lang = $_GET['lang'] ?? 'en';
        I18n::setLang($lang);
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
    }
}
