<?php require_once __DIR__ . '/../parts/header.php'; ?>
<div class="container mt-4">
    <h1 class="mb-4">Мови</h1>
    <a href="language/create" class="btn btn-primary mb-3">Додати мову</a>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Назва</th>
            <th>Код</th>
            <th>Дії</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($languages as $language): ?>
            <tr>
                <td><?= htmlspecialchars($language['id']) ?></td>
                <td><?= htmlspecialchars($language['name']) ?></td>
                <td><?= htmlspecialchars($language['code']) ?></td>
                <td>
                    <a href="language/edit/<?= $language['id'] ?>" class="btn btn-sm btn-warning">Редагувати</a>
                    <a href="language/delete/<?= $language['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
