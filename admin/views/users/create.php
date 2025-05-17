<?php require_once __DIR__ . '/../parts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4 text">Створити користувача</h2>

    <form method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Ім’я користувача</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Роль</label>
            <select name="role" id="role" class="form-select" required>
                <option value="user">Користувач</option>
                <option value="admin">Адмін</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Зберегти</button>
    </form>
</div>
