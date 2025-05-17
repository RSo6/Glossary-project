<?php require_once __DIR__ . '/../parts/header.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4">Список словників</h2>

    <a href="dictionary/create" class="btn btn-primary">Додати новий словник</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Мова джерела</th>
            <th>Мова перекладу</th>
            <th>Дії</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($dictionaries as $dict): ?>
            <tr>
                <td><?= htmlspecialchars($dict['id']) ?></td>
                <td><?= htmlspecialchars($dict['source']) ?></td>
                <td><?= htmlspecialchars($dict['target']) ?></td>
                <td>
                    <a href="dictionary/edit/<?= $dict['id'] ?>" class="btn btn-sm btn-warning">Редагувати</a>
                    <a href="dictionary/delete/<?= $dict['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
