<?php require_once __DIR__ . '/../parts/header.php'; ?>
<div class="container mt-4">
<h2 class="mb-4">Переклади</h2>

<a href="translation/create" class="btn btn-primary">Додати новий переклад</a><br>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
    <tr>
        <th>ID</th>
        <th>Слово</th>
        <th>Переклад</th>
        <th>Мова</th>
        <th>Дії</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($translations as $translation): ?>
        <tr>
            <td><?= $translation['id']; ?></td>
            <td><?= $translation['word_id']; ?></td>
            <td><?= $translation['translated_text']; ?></td>
            <td><?= $translation['target_language_id']; ?></td>
            <td>
                <a href="translation/edit/<?= $translation['id']; ?>" class="btn btn-warning">Редагувати</a>
                <a href="translation/delete/<?= $translation['id']; ?>" class="btn btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>


