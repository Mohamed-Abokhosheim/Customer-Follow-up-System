<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController
{
    public function index()
    {
        Auth::adminOnly();
        $userModel = new UserModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CSRF::verify($_POST['csrf_token']);
            $data = [
                'name' => $_POST['name'],
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password'] ?? '',
                'role' => $_POST['role'],
                'status' => $_POST['status'],
                'lang_pref' => $_POST['lang_pref'],
            ];

            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $userModel->update($_POST['id'], $data);
                Flash::set('success', 'User updated');
            } else {
                $userModel->create($data);
                Flash::set('success', 'User created');
            }
            header('Location: index.php?route=admin/users');
            exit;
        }

        $users = $userModel->getAll();
        $title = __('user_management');
        include __DIR__ . '/../views/admin/users.php';
    }
}
