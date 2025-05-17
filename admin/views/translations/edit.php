<?php require_once __DIR__ . '/../parts/header.php'; ?>
<div class="container mt-4">
<h1>Редагувати переклад</h1>

<form action="/Dictionary/admin/translation/edit/<?= $translation['id']; ?>" method="post">
    <div class="form-group">
        <label for="word_id">Слово</label>
        <input type="text" class="form-control" id="word_id" name="word_id" value="<?= $translation['word_id']; ?>" required>
    </div>
    <div class="form-group">
        <label for="translated_text">Переклад</label>
        <input type="text" class="form-control" id="translated_text" name="translated_text" value="<?= $translation['translated_text']; ?>" required>
    </div>
    <div class="form-group">
        <label for="target_language_id">Мова</label>
        <input type="text" class="form-control" id="target_language_id" name="target_language_id" value="<?= $translation['target_language_id']; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Оновити</button>
</form>
</div>

