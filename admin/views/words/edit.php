<?php require_once __DIR__ . '/../parts/header.php'; ?>
<div class="container mt-4">
<h2>Edit Word</h2>
<form method="post">
    <input type="text" name="word_text" class="form-control mb-2" value="<?= $word['word_text'] ?>" required>
    <select type="number" name="language_id" class="form-control mb-2" required>
           <?php foreach ($languages as $lang): ?>
            <option value="<?= $lang['id'] ?>"><?= htmlspecialchars($lang['name']) ?></option>
    <?php endforeach; ?>"
    </select>
    <button class="btn btn-primary">Update</button>
</form>
</div>
