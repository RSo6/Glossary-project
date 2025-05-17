<?php

namespace admin\controllers;

use admin\models\User;

class UserController {
    private $pdo;
    private $model;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->model = new User($pdo);
    }

    public function index() {
        $users = $this->model->getAll();
        require __DIR__ . '/../views/users/user.php';
    }
    private function redirect($url) {
        header("Location: /Dictionary/admin/$url");
        exit;
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';

            if (!$username || !$password) {
                $error = 'Ім’я користувача та пароль обов’язкові.';
                if (count($password) < 8) {
                    $error .= 'Довжина паролю занадто коротка, мінімум 8 символів.';
                }

                require __DIR__ . '/../views/users/create.php';
                return;
            }

            $this->model->create($username, $password, $role);
            $this->redirect('user');
            exit;
        }

        require __DIR__ . '/../views/users/create.php';
    }


    public function edit($id) {
        $user = $this->model->getById((int)$id);

        if (!$user) {
            http_response_code(404);
            echo "User not found.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? null;
            $role = $_POST['role'] ?? 'user';

            if (!$username) {
                $error = 'Username is required.';
                require __DIR__ . '/../views/users/edit.php';
                return;
            }

            $this->model->update((int)$id, $username, $password, $role);
            $this->redirect('user');
            exit;
        }

        require __DIR__ . '/../views/users/edit.php';
    }


    public function delete($id) {
        $this->model->delete($id);
        $this->redirect('user');
    }
}
