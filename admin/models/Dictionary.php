<?php

namespace admin\models;

class Dictionary {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT d.id, sl.name AS source, tl.name AS target
            FROM dictionaries d
            JOIN languages sl ON d.source_language_id = sl.id
            JOIN languages tl ON d.target_language_id = tl.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM dictionaries WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($sourceLanguageId, $targetLanguageId) {
        $stmt = $this->pdo->prepare("INSERT INTO dictionaries (source_language_id, target_language_id) VALUES (?, ?)");
        return $stmt->execute([$sourceLanguageId, $targetLanguageId]);
    }

    public function update($id, $sourceLanguageId, $targetLanguageId) {
        $stmt = $this->pdo->prepare("UPDATE dictionaries SET source_language_id = ?, target_language_id = ? WHERE id = ?");
        return $stmt->execute([$sourceLanguageId, $targetLanguageId, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM dictionaries WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function getByDictionaryId($dictionary_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM words WHERE dictionary_id = ?");
        $stmt->execute([$dictionary_id]);
        return $stmt->fetchAll();
    }
    public function getDictionaries(): array {
        $stmt = $this->pdo->query("SELECT id, source_language_id, target_language_id FROM dictionaries");
        return $stmt->fetchAll();
    }
}
