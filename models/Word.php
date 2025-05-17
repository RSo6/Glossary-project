<?php

namespace models;

class Word {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllByLanguage($languageId) {
        $languageId = (int)$languageId;
        $sql = "SELECT * FROM words WHERE language_id = :languageId ORDER BY word_text ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':languageId' => $languageId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getByFirstLetter($letter, $languageId, $dictionaryId) {
        $letter = $letter . '%';
        $languageId = (int)$languageId;
        $dictionaryId = (int)$dictionaryId;

        $sql = "SELECT w.id, w.word_text
            FROM words w
            JOIN dictionaries d ON w.dictionary_id = d.id
            WHERE w.language_id = :languageId 
            AND w.word_text LIKE :letter 
            AND w.dictionary_id = :dictionaryId
            ORDER BY w.word_text ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':languageId' => $languageId,
            ':letter' => $letter,
            ':dictionaryId' => $dictionaryId
        ]);

        return $stmt->fetchAll();
    }

    public function getWordsByIds(array $ids): array {
        if (empty($ids)) return [];

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->pdo->prepare("
    SELECT w.id, w.word_text, l.name AS language
    FROM words w
    JOIN languages l ON w.language_id = l.id
    WHERE w.id IN ($placeholders)
");
        $stmt->execute($ids);

        return $stmt->fetchAll();
    }
    public function isWordSaved(int $userId, int $wordId): bool {
        $stmt = $this->pdo->prepare("SELECT 1 FROM user_saved_words WHERE user_id = ? AND word_id = ?");
        $stmt->execute([$userId, $wordId]);
        return (bool) $stmt->fetchColumn();
    }

    public function saveWord(int $userId, int $wordId): void {
        $stmt = $this->pdo->prepare("INSERT IGNORE INTO user_saved_words (user_id, word_id) VALUES (?, ?)");
        $stmt->execute([$userId, $wordId]);
    }

    public function removeSavedWord(int $userId, int $wordId): void {
        $stmt = $this->pdo->prepare("DELETE FROM user_saved_words WHERE user_id = ? AND word_id = ?");
        $stmt->execute([$userId, $wordId]);
    }

    public function getSavedWordIds($userId): array {
        $stmt = $this->pdo->prepare("SELECT word_id FROM user_saved_words WHERE user_id = ?");
        $stmt->execute([$userId]);
        return array_column($stmt->fetchAll(), 'word_id');
    }

    public function getTranslationsForWord(int $wordId): array {
        $stmt = $this->pdo->prepare("
        SELECT t.translated_text, l.name AS language
        FROM translations t
        JOIN languages l ON t.target_language_id = l.id
        WHERE t.word_id = ?
    ");
        $stmt->execute([$wordId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function searchWords(string $query, int $languageId, int $dictionaryId): array {
        $stmt = $this->pdo->prepare("
        SELECT id, word_text FROM words
        WHERE word_text LIKE :query
          AND language_id = :languageId
          AND dictionary_id = :dictionaryId
        ORDER BY word_text ASC
    ");
        $stmt->execute([
            ':query' => '%' . $query . '%',
            ':languageId' => $languageId,
            ':dictionaryId' => $dictionaryId
        ]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }



}