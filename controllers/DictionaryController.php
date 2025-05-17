<?php

namespace controllers;

use models\User;
use models\Word;
use models\Translation;
use models\Language;
use models\Dictionary;

class DictionaryController {
    private $db;
    private $wordModel;
    private $translationModel;
    private $languageModel;
    private $dictionaryModel;

    public function __construct($db) {
        $this->db = $db;
        $this->wordModel = new Word($db);
        $this->translationModel = new Translation($db);
//        $this->languageModel = new Language($db);
        $this->dictionaryModel = new Dictionary($db);
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $dictionaryId = $_GET['dict'] ?? 1;
        $dictionary = $this->getDictionary($dictionaryId);

        $languageId = $dictionary['source_language_id'];
        $targetLanguageId = $dictionary['target_language_id'];
        $sourceLanguageCode = $dictionary['source_code'];

        $searchTerm = trim($_GET['search'] ?? '');

        if ($searchTerm !== '') {
            $words = $this->wordModel->searchWords($searchTerm, $languageId, $dictionaryId);
            $wordsByLetter = [];

            foreach ($words as $word) {
                $letter = mb_strtoupper(mb_substr($word['word_text'], 0, 1));
                $wordsByLetter[$letter][] = $word;
            }

            $alphabet = array_keys($wordsByLetter);
            sort($alphabet);
        } else {
            $alphabet = $this->getAlphabetByLanguageCode($sourceLanguageCode) ?: range('A', 'Z');
            $wordsByLetter = [];

            foreach ($alphabet as $letter) {
                $wordsByLetter[$letter] = $this->listByLetter($letter, $languageId, $dictionaryId);
            }
        }

        $dictionaries = $this->listDictionaries();

        $translations = [];
        foreach ($wordsByLetter as $letter => $words) {
            foreach ($words as $word) {
                $translations[$letter][$word['id']] = $this->getTranslations($word['id'], $targetLanguageId, $dictionaryId);
            }
        }

        $savedWordIds = [];
        if (isset($_SESSION['user'])) {
            $userModel = new \models\User($this->db);
            $savedWordIds = $this->wordModel->getSavedWordIds($_SESSION['user']['id']);
        }

        require "views/index.php";
    }


    public function getAlphabetByLanguageCode($languageCode): array {
        $path = __DIR__ . '/../data/alphabets.json';
        if (!file_exists($path)) return [];

        $json = file_get_contents($path);
        $alphabets = json_decode($json, true);

        return $alphabets[strtolower($languageCode)] ?? [];
    }

    public function listByLetter($letter, $languageId, $dictionaryId) {
        return $this->wordModel->getByFirstLetter($letter, $languageId, $dictionaryId);
    }

    public function getTranslations($wordId, $targetLanguageId, $dictionaryId) {
        return $this->translationModel->getTranslationsForWord($wordId, $targetLanguageId, $dictionaryId);
    }


    public function listDictionaries() {
        return $this->dictionaryModel->getAll();
    }

    public function getDictionary($id) {
        return $this->dictionaryModel->getById($id);
    }
}
