<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Увійти — Словник</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .auth-form {
            max-width: 400px;
            margin: 200px auto 40px;
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }
        .auth-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #3f8cff;
        }
        .auth-form label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }
        .auth-form input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #444;
            margin-bottom: 20px;
            background-color: #121212;
            color: #f1f1f1;
        }
        .auth-form button {
            width: 100%;
            padding: 10px;
            background-color: #3f8cff;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .auth-form button:hover {
            background-color: #007acc;
        }
        .auth-form .error {
            color: #ff6b6b;
            text-align: center;
            margin-top: 10px;
        }
        .auth-form .link {
            text-align: center;
            margin-top: 10px;
            color: #ccc;
        }
        .auth-form .link a {
            color: #3f8cff;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="auth-form">
    <h2>Увійти</h2>
    <form method="POST">
        <label for="username">Ім’я користувача</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Увійти</button>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <p class="link">Ще не маєте акаунту? <a href="/Dictionary/register">Зареєструйтесь</a></p>
    </form>
</div>
</body>
</html>
