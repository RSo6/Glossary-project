<?php

namespace models;

class Dictionary {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getAll() {
        $sql = "SELECT d.id, l1.name AS source, l2.name AS target, l1.code AS source_code
                FROM dictionaries d
                JOIN languages l1 ON d.source_language_id = l1.id
                JOIN languages l2 ON d.target_language_id = l2.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {

        $stmt = $this->pdo->prepare("
        SELECT d.*, 
               sl.code AS source_code, 
               tl.code AS target_code,
               sl.name AS source, 
               tl.name AS target
        FROM dictionaries d
        JOIN languages sl ON d.source_language_id = sl.id
        JOIN languages tl ON d.target_language_id = tl.id
        WHERE d.id = ?
    ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
