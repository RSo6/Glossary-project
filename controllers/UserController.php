<?php

namespace controllers;

use models\User;
use models\Word;

class UserController {
    private $userModel;
    private $wordModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
        $this->wordModel = new Word($pdo);
    }

    public function profile() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /Dictionary/login");
            exit;
        }

        $userId = $_SESSION['user']['id'];

        $savedWordIds = $this->wordModel->getSavedWordIds($userId);

        $savedWords = $this->wordModel->getWordsByIds($savedWordIds);

        $translationsMap = [];
        foreach ($savedWords as $word) {
            $translationsMap[$word['id']] = $this->wordModel->getTranslationsForWord($word['id']);
        }

        // Передаємо змінні у view
        require "views/user/profile.php";
    }

    public function saveWord() {
        session_start();
        if (!isset($_SESSION['user']) || !isset($_POST['word_id'])) {
            http_response_code(400);
            echo "Недостатньо даних";
            return;
        }

        $userId = $_SESSION['user']['id'];
        $wordId = (int) $_POST['word_id'];

        $this->wordModel->saveWord($userId, $wordId);
        header("Location: /Dictionary/user/profile");
    }

    public function toggleSaveWord() {
        session_start();
        if (!isset($_SESSION['user']) || !isset($_POST['word_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Not logged in or no word_id']);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $wordId = (int) $_POST['word_id'];

        if ($this->wordModel->isWordSaved($userId, $wordId)) {
            $this->wordModel->removeSavedWord($userId, $wordId);
            echo json_encode(['status' => 'removed']);
        } else {
            $this->wordModel->saveWord($userId, $wordId);
            echo json_encode(['status' => 'saved']);
        }
    }
}
