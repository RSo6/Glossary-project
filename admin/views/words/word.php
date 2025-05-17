<?php
require_once __DIR__ . '/../parts/header.php';
?>
<div class="container mt-4">
    <h2 class="mb-4">Words</h2>
    <a href="word/create" class="btn btn-primary mb-3">Додати слово</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Word</th>
            <th>Language</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($words as $word): ?>
            <tr>
                <td><?= htmlspecialchars($word['id']) ?></td>
                <td><?= htmlspecialchars($word['word_text']) ?></td>
                <td><?= htmlspecialchars($word['language_name']) ?></td>
                <td>
                    <a href="word/edit/<?= $word['id'] ?>" class="btn btn-sm btn-warning">Редагувати</a>
                    <a href="word/delete/<?= $word['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
