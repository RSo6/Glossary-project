<?php

namespace admin\models;

class Word {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT w.id, w.word_text, l.name AS language_name
            FROM words w
            JOIN languages l ON w.language_id = l.id
        ");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT w.*, l.name AS language_name
            FROM words w
            JOIN languages l ON w.language_id = l.id
            WHERE w.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($word_text, $language_id, $dictionary_id) {
        $stmt = $this->pdo->prepare("
            INSERT INTO words (word_text, language_id, dictionary_id)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$word_text, $language_id, $dictionary_id]);
    }

    public function update($id, $word_text, $language_id) {
        $stmt = $this->pdo->prepare("
            UPDATE words SET word_text = ?, language_id = ?
            WHERE id = ?
        ");
        return $stmt->execute([$word_text, $language_id, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM words WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getLanguages(): array {
        $stmt = $this->pdo->query("SELECT id, name FROM languages");
        return $stmt->fetchAll();
    }




}
