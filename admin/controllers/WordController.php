<?php
namespace admin\controllers;

use admin\models\Word;
use admin\models\Dictionary;
class WordController {
    private $model;
    private $dictionaryModel;


    public function __construct($pdo) {
        $this->model = new Word($pdo);
        $this->dictionaryModel = new Dictionary($pdo);
    }

    private function redirect($url) {
        header("Location: /Dictionary/admin/$url");
        exit;
    }

    public function index() {
        $words = $this->model->getAll();
        require_once __DIR__ . '/../views/words/word.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $word_text = $_POST['word_text'];
            $language_id = $_POST['language_id'];
            $dictionary_id = $_POST['dictionary_id'];

            $this->model->create($word_text, $language_id, $dictionary_id);

            $this->redirect('word');
        }
        $languages = $this->model->getLanguages();
//        $dictionaries = $this->dictionaryModel->getDictionaries();
        $dictionaries= $this->dictionaryModel->getAll();

        require_once __DIR__ . '/../views/words/create.php';
    }

    public function edit($id) {
        $word = $this->model->getById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST['word_text'], $_POST['language_id']);
            $this->redirect('word');
        }
        $languages = $this->model->getLanguages();
        require_once __DIR__ . '/../views/words/edit.php';
    }

    public function delete($id) {
        $this->model->delete($id);
        $this->redirect('word');
    }
}
