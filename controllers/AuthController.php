<?php

namespace controllers;

use models\User;

class AuthController {
    private $model;

    public function __construct($pdo) {
        $this->model = new User($pdo);
    }

    public function login() {
        session_start();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (strlen($password) < 8 ) {
                $error = 'Пароль повинен бути не менше 8 символів.';
            } else {
                $user = $this->model->authenticate($username, $password);
            }
            if ($user) {
                $_SESSION['user'] = $user;
                if ($this->model->isAdmin($username)) {
                    header('Location: /Dictionary/admin');
                    exit;
                } else {
                    header('Location: /Dictionary/');
                    exit;
                }
            } else {
                $error = 'Невірне ім’я користувача або пароль.';
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }
    public function register() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password_repeat = $_POST['password_repeat'];

            if (strlen($password) < 8) {
                $error = 'Пароль повинен бути не менше 8 символів.';
            }
            else if ($password !== $password_repeat) {
                $error = 'Паролі не збігаються.';
            }
            else if ($this->model->userExists($username)) {
                $error = 'Користувач із таким ім’ям вже існує.';
            }
            else {
                $success = $this->model->create($username, $password);
                if ($success) {
                    header('Location: /Dictionary/login');
                    exit;
                } else {
                    $error = 'Користувача не вдалося створити.';
                }
            }
        }

        require __DIR__ . '/../views/auth/register.php';
    }


    public function logout() {
        session_start();
        session_destroy();
        header('Location: /Dictionary/');
        exit;
    }
}
