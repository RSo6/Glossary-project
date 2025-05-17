<?php /** @var array $savedWords */ ?>
<?php /** @var models\Word $wordModel */ ?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Особистий кабінет</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <h1>Особистий кабінет</h1>
</header>
<main>
    <h2>Ваші збережені слова</h2>
    <?php if (empty($savedWords)): ?>
        <p>Немає збережених слів.</p>
    <?php else: ?>
        <div class="word-grid">
            <?php foreach ($savedWords as $word): ?>
                <div class="definition card"> <!-- та сама структура -->
                    <h3 class="word-title"><?= htmlspecialchars($word['word_text']) ?></h3>
                    <p class="word-language"><?= isset($word['language']) ? htmlspecialchars($word['language']) : 'Невідома мова' ?></p>

                    <?php
                    $translations = $translationsMap[$word['id']] ?? [];
                    if (!empty($translations)): ?>
                        <ul class="translation-list">
                            <?php foreach ($translations as $translation): ?>
                                <li class="translation-item">
                                    <?= htmlspecialchars($translation['translated_text']) ?>
                                    <span class="text-muted">(<?= htmlspecialchars($translation['language']) ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="no-translation"><em>Переклади відсутні</em></p>
                    <?php endif; ?>

                    <button class="save-word-btn" data-word-id="<?= $word['id'] ?>">
                        <i class="fas fa-heart <?= in_array($word['id'], $savedWordIds) ? 'saved' : '' ?>"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>


<script>
    document.querySelectorAll('.save-word-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const wordId = this.dataset.wordId;
            const icon = this.querySelector('i');

            fetch('<?= BASE_URL ?>/user/toggleSaveWord', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'word_id=' + wordId
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'saved') {
                        icon.classList.add('saved');
                    } else if (data.status === 'removed') {
                        icon.classList.remove('saved');
                    }
                });
        });
    });
</script>

</body>
</html>
