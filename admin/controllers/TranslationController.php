<?php

namespace admin\controllers;

use admin\models\Translation;
use admin\models\Word;
use admin\models\Language;
use admin\models\Dictionary;

class TranslationController {
    private $model;
    private $wordModel;
    private $languageModel;
    private $dictionaryModel;

    public function __construct($pdo) {
        $this->model = new Translation($pdo);
        $this->wordModel = new Word($pdo);
        $this->languageModel = new Language($pdo);
        $this->dictionaryModel = new Dictionary($pdo);
    }

    private function redirect($url) {
        header("Location: /Dictionary/admin/$url");
        exit;
    }

    public function index() {
        $translations = $this->model->getAll();
        require_once __DIR__ . '/../views/translations/translation.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $word_id = $_POST['word_id'];
            $translated_text = $_POST['translated_text'];
            $target_language_id = $_POST['target_language_id'];
            $dictionary_id = $_POST['dictionary_id'];

            $this->model->create($word_id, $translated_text, $target_language_id, $dictionary_id);
            $this->redirect('translation');
        }

        $words = $this->wordModel->getAll();
        $languages = $this->languageModel->getAll();
        $dictionaries = $this->dictionaryModel->getAll();
        require_once __DIR__ . '/../views/translations/create.php';
    }

    public function edit($id) {
        $translation = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $word_id = $_POST['word_id'];
            $translated_text = $_POST['translated_text'];
            $target_language_id = $_POST['target_language_id'];

            $this->model->update($id, $word_id, $translated_text, $target_language_id);
            $this->redirect('translation');
        }

        $words = $this->wordModel->getAll();
        $languages = $this->languageModel->getAll();
        require_once __DIR__ . '/../views/translations/edit.php';
    }

    public function delete($id) {
        $this->model->delete($id);
        $this->redirect('translation');
    }
    public function getWordsByDictionary() {
        if (isset($_GET['dictionary_id'])) {
            $dictionary_id = $_GET['dictionary_id'];
            $words = $this->dictionaryModel->getByDictionaryId($dictionary_id);
            header('Content-Type: application/json');
            echo json_encode($words);
            exit;
        }
    }

}
