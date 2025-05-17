<?php

namespace admin\controllers;

use admin\models\Admin;
class AdminController {
    private $pdo;
    private $model;
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->model = new Admin($pdo);
    }

    public function index() {
        $counts = $this->getCounts();
        require_once __DIR__ . '/../views/main.php';
    }

    public function getCounts(): array {
        return [
            'words' => $this->model->countTable('words'),
            'translations' => $this->model->countTable('translations'),
            'languages' => $this->model->countTable('languages'),
            'dictionaries' => $this->model->countTable('dictionaries'),
            'users' => $this->model->countTable('users'),
        ];
    }


}
