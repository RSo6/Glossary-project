<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Словник</title>
    <link rel="stylesheet" href="assets/style.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <form class="search-form" method="get" action="">
        <input type="hidden" name="dict" value="<?= htmlspecialchars($dictionaryId) ?>">
        <input type="text" name="search" placeholder="Пошук слова..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>

    <h1>Словники</h1>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="auth-controls">
            <a href="<?= BASE_URL ?>/user/profile" class="auth-btn">
                <i class="fas fa-user"></i> Особистий кабінет
            </a>
            <a href="<?= BASE_URL ?>/logout" class="auth-btn">
                <i class="fas fa-sign-out-alt"></i> Вийти
            </a>
        </div>
    <?php else: ?>
        <div class="auth-controls">
            <a href="<?= BASE_URL ?>/login" class="auth-btn">
                <i class="fas fa-sign-in-alt"></i> Увійти
            </a>
            <a href="<?= BASE_URL ?>/register" class="auth-btn">
                <i class="fas fa-user-plus"></i> Реєстрація
            </a>
        </div>
    <?php endif; ?>



    <div class="dictionary-stack">
        <?php foreach ($dictionaries as $dict): ?>
            <a href="?dict=<?= $dict['id'] ?>"
               class="<?= ($_GET['dict'] ?? $dictionaryId) == $dict['id'] ? 'active' : '' ?>">
                <?= htmlspecialchars($dict['source']) ?> → <?= htmlspecialchars($dict['target']) ?>
            </a>
        <?php endforeach; ?>
    </div>

</header>
<main>
    <nav class="alphabet">
        <?php foreach ($alphabet as $letter): ?>
            <a href="#<?= $letter ?>"><?= $letter ?></a>
        <?php endforeach; ?>
    </nav>
    <?php foreach ($wordsByLetter as $letter => $words): ?>
        <?php if (!empty($words)): ?>
            <section id="<?= $letter ?>">
                <h2><?= $letter ?></h2>
                <div class="word-grid">
                    <?php foreach ($words as $word): ?>
                        <div class="definition card">
                            <h3 class="word-title"><?= htmlspecialchars($word['word_text']) ?></h3>
                            <?php
                            $wordTranslations = $translations[$letter][$word['id']] ?? [];
                            ?>
                            <?php if (!empty($wordTranslations)): ?>
                                <ul class="translation-list">
                                    <?php foreach ($wordTranslations as $translation): ?>
                                        <li class="translation-item"><?= htmlspecialchars($translation['text']) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="no-translation"><em>Переклади відсутні</em></p>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['user'])): ?>
                                <?php $isSaved = in_array($word['id'], $savedWordIds); ?>
                                <button class="save-word-btn" data-word-id="<?= $word['id'] ?>">
                                    <i class="fas fa-heart <?= $isSaved ? 'saved' : '' ?>"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    <?php endforeach; ?>
</main>



<script>
    const sections = document.querySelectorAll('main section');
    const navLinks = document.querySelectorAll('.alphabet a');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 110;
            if (window.scrollY >= sectionTop) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });

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
