<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ6QqJ2a2Y9POZ14xB5inHGRlmz7z9u4lF7l1lLrhhZ0hHjlDAcJ8VY3zXzt" crossorigin="anonymous">
    <style>
        .card {
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-light">

<?php require_once __DIR__ . '/parts/header.php'; ?>

<div class="container py-5">
    <h1 class="mb-4 text-center text-primary">📚 Dictionary Admin Panel</h1>

    <div class="row g-4">
        <?php
        $panels = [
            'Words' => ['count' => $counts['words'], 'link' => 'word', 'color' => 'primary'],
            'Translations' => ['count' => $counts['translations'], 'link' => 'translation', 'color' => 'success'],
            'Languages' => ['count' => $counts['languages'], 'link' => 'language', 'color' => 'info'],
            'Dictionaries' => ['count' => $counts['dictionaries'], 'link' => 'dictionary', 'color' => 'warning'],
            'Users' => ['count' => $counts['users'], 'link' => 'user', 'color' => 'danger'],
        ];

        foreach ($panels as $name => $data): ?>
            <div class="col-md-4">
                <div class="card border-<?= $data['color'] ?> shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?= $name ?></h5>
                        <p class="card-text fs-2 text-center"><?= $data['count'] ?></p>
                        <div class="d-grid gap-2">
                            <a href="<?= $data['link'] ?>" class="btn btn-<?= $data['color'] ?> btn-lg">Manage <?= $name ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once __DIR__ . '/parts/footer.php'; ?>

</body>
</html>
