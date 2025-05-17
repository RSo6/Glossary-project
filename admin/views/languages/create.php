<?php require_once __DIR__ . '/../parts/header.php'; ?>
<div class="container mt-4">
    <h1 class="mb-4">Додати мову</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Назва:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Код:</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>

        <button type="submit" class="btn btn-success">Зберегти</button>
        <a href="/Dictionary/admin/language" class="btn btn-secondary">Скасувати</a>
    </form>
</div>
