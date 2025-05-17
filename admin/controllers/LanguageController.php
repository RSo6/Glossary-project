<?php

namespace admin\controllers;

use admin\models\Language;

class LanguageController {
    private $model;

    public function __construct($pdo) {
        $this->model = new Language($pdo);
    }

    private function redirect($url) {
        header("Location: /Dictionary/admin/$url");
        exit;
    }

    public function index() {
        $languages = $this->model->getAll();
        require_once __DIR__ . '/../views/languages/language.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $code = $_POST['code'];

            $this->model->create($name, $code);
            $this->redirect('language');
        }

        require_once __DIR__ . '/../views/languages/create.php';
    }

    public function edit($id) {
        $language = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $code = $_POST['code'];

            $this->model->update($id, $name, $code);
            $this->redirect('language');
        }

        require_once __DIR__ . '/../views/languages/edit.php';
    }

    public function delete($id) {
        $this->model->delete($id);
        $this->redirect('language');
    }
}
