<?php

namespace admin\controllers;

use admin\models\Dictionary;
use admin\models\Language;

class DictionaryController {
    private $model;
    private $languageModel;

    public function __construct($pdo) {
        $this->model = new Dictionary($pdo);
        $this->languageModel = new Language($pdo);
    }

    private function redirect($url) {
        header("Location: /Dictionary/admin/$url");
        exit;
    }

    public function index() {
        $dictionaries = $this->model->getAll();
        require_once __DIR__ . '/../views/dictionaries/dictionary.php';
    }

    public function create() {
        $languages = $this->languageModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sourceId = $_POST['source_language_id'];
            $targetId = $_POST['target_language_id'];

            $this->model->create($sourceId, $targetId);
            $this->redirect('dictionary');
        }

        require_once __DIR__ . '/../views/dictionaries/create.php';
    }

    public function edit($id) {
        $dictionary = $this->model->getById($id);
        $languages = $this->languageModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sourceId = $_POST['source_language_id'];
            $targetId = $_POST['target_language_id'];

            $this->model->update($id, $sourceId, $targetId);
            $this->redirect('dictionary');
        }

        require_once __DIR__ . '/../views/dictionaries/edit.php';
    }

    public function delete($id) {
        $this->model->delete($id);
        $this->redirect('dictionary');
    }
}
