<?php require_once __DIR__ . '/../parts/header.php'; ?>

<div class="container mt-4">
<h2 class="mb-4">Додати новий переклад</h2>
    <script>
        function loadWords(dictionaryId) {
            const wordSelect = document.getElementById('wordSelect');
            wordSelect.innerHTML = '<option>Завантаження...</option>';

            fetch(`/Dictionary/admin/translation/getWordsByDictionary?dictionary_id=${dictionaryId}`)
                .then(response => response.json())
                .then(words => {
                    wordSelect.innerHTML = '<option value="">Оберіть слово</option>';
                    words.forEach(word => {
                        const option = document.createElement('option');
                        option.value = word.id;
                        option.textContent = word.word_text;
                        wordSelect.appendChild(option);
                    });
                });
        }
    </script>

<form action="create" method="post">

        <div class="form-group">
            <label for="dictionary_id">Словник</label>
            <select name="dictionary_id" class="form-select mb-3" id="dictionarySelect" onchange="loadWords(this.value)" required>
                <option value="">Оберіть словник</option>
                <?php foreach ($dictionaries as $dict): ?>
                    <option value="<?= $dict['id'] ?>">
                        <?= htmlspecialchars($dict['source']) ?> - <?= htmlspecialchars($dict['target']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="word_id">Слово</label>
            <select name="word_id" class="form-select mb-3" id="wordSelect" required>
                <option value="">Оберіть словник спочатку</option>
            </select>
        </div>

        <div class="form-group">
            <label for="translated_text">Переклад</label>
            <input type="text" class="form-control" id="translated_text" name="translated_text" required>
        </div>

        <div class="form-group">
            <label for="target_language_id">Мова перекладу</label>
            <select name="target_language_id" class="form-select mb-3" required>
                <option value="">Виберіть мову</option>
                <?php foreach ($languages as $language): ?>
                    <option value="<?= $language['id'] ?>"><?= htmlspecialchars($language['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Зберегти</button>
    </form>

</div>

