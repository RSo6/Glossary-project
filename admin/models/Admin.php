<?php

namespace admin\models;

class Admin
{
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function countTable(string $table): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM $table");
        return (int)$stmt->fetchColumn();
    }
}