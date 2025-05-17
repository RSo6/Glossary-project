<?php

namespace models;

class User
{
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }
    public function authenticate(string $username, string $password): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
    public function create(string $username, string $password): bool {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashedPassword]);
    }
    public function userExists(string $username): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }
    public function isAdmin(string $username): bool {
        $stmt = $this->pdo->prepare("SELECT role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch();
        return $result && isset($result['role']) && $result['role'] === 'admin';
    }



}