<?php require_once __DIR__ . '/../parts/header.php'; ?>
<div class="container mt-4">
<h2 class="mb-4">Створити слово</h2>

<form method="post">
    <input type="text" name="word_text" class="form-control mb-3" placeholder="Word Text" required>

    <select name="language_id" class="form-select mb-3" required>
        <option value="">Виберіть мову</option>
        <?php foreach ($languages as $lang): ?>
            <option value="<?= $lang['id'] ?>"><?= htmlspecialchars($lang['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <select name="dictionary_id" class="form-select mb-3" required>
        <option value="">Виберіть словник</option>
        <?php foreach ($dictionaries as $dict): ?>
            <option value="<?= $dict['id'] ?>">
                <?= htmlspecialchars($dict['source']) ?> - <?= htmlspecialchars($dict['target']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button class="btn btn-success">Зберегти</button>
</form>
</div>
