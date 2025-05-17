<?php

namespace models;

class Translation {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getTranslationsForWord($wordId, $targetLanguageId, $dictionaryId) {
        $stmt = $this->pdo->prepare("
        SELECT translated_text AS text 
        FROM translations 
        WHERE word_id = ? AND target_language_id = ? AND dictionary_id = ?
    ");
        $stmt->execute([$wordId, $targetLanguageId, $dictionaryId]);
        return $stmt->fetchAll();
    }



}
