<?php require_once __DIR__ . '/../parts/header.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4">Створити переклад</h2>

    <form method="post">
        <select name="source_language_id" class="form-select mb-3" required>
            <option value="">Оберіть мову джерела</option>
            <?php foreach ($languages as $lang): ?>
                <option value="<?= $lang['id'] ?>"><?= htmlspecialchars($lang['name']) ?> (<?= $lang['code'] ?>)</option>
            <?php endforeach; ?>
        </select>

        <select name="target_language_id" class="form-select mb-3" required>
            <option value="">Оберіть мову перекладу</option>
            <?php foreach ($languages as $lang): ?>
                <option value="<?= $lang['id'] ?>"><?= htmlspecialchars($lang['name']) ?> (<?= $lang['code'] ?>)</option>
            <?php endforeach; ?>
        </select>

        <button class="btn btn-success">Зберегти</button>
    </form>

</div>
