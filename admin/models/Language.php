<?php

namespace admin\models;

class Language {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM languages");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM languages WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($name, $code) {
        $stmt = $this->pdo->prepare("INSERT INTO languages (name, code) VALUES (?, ?)");
        return $stmt->execute([$name, $code]);
    }

    public function update($id, $name, $code) {
        $stmt = $this->pdo->prepare("UPDATE languages SET name = ?, code = ? WHERE id = ?");
        return $stmt->execute([$name, $code, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM languages WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
