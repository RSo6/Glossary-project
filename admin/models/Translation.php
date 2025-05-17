<?php

namespace admin\models;

class Translation {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getAll($dictionary_id = null) {
        $sql = "SELECT t.*, w.word_text, l.name AS target_language
            FROM translations t
            JOIN words w ON t.word_id = w.id
            JOIN languages l ON t.target_language_id = l.id";

        if ($dictionary_id) {
            $sql .= " WHERE t.dictionary_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$dictionary_id]);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }

        return $stmt->fetchAll();
    }


    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM translations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($word_id, $translated_text, $target_language_id, $dictionary_id) {
        $stmt = $this->pdo->prepare("INSERT INTO translations (word_id, translated_text, target_language_id, dictionary_id)
                                  VALUES (?, ?, ?, ?)");
        return $stmt->execute([$word_id, $translated_text, $target_language_id, $dictionary_id]);
    }

    public function update($id, $word_id, $translated_text, $target_language_id) {
        $stmt = $this->pdo->prepare("UPDATE translations
                                      SET word_id = ?, translated_text = ?, target_language_id = ?
                                      WHERE id = ?");
        return $stmt->execute([$word_id, $translated_text, $target_language_id, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM translations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
