<h1>Редагувати урок #<?= $lesson['id'] ?></h1>
<form method="post" action="/admin/lessons/update" class="lesson-form">
    <input type="hidden" name="id" value="<?= $lesson['id'] ?>">

    <label for="title">Title:</label>
    <input id="title" name="title" type="text" value="<?= htmlspecialchars($lesson['title']) ?>" required><br>

    <label for="content">Content:</label>
    <textarea id="content" name="content" required><?= htmlspecialchars($lesson['content']) ?></textarea><br>

    <label for="lang">Language:</label>
    <select id="lang" name="lang">
        <option value="ua" <?= $lesson['lang'] === 'ua' ? 'selected' : '' ?>>Українська</option>
        <option value="en" <?= $lesson['lang'] === 'en' ? 'selected' : '' ?>>English</option>
    </select><br>

    <label for="category_id">Category:</label>
    <select id="category_id" name="category_id">
        <option value="0">— без категорії —</option>
        <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $c['id'] == $lesson['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label for="tags">Tags (csv):</label>
    <input id="tags" name="tags" type="text" value="<?= htmlspecialchars($lesson['tags'] ?? '') ?>"><br>

    <label for="difficulty">Difficulty:</label>
    <select id="difficulty" name="difficulty">
        <option value="easy" <?= $lesson['difficulty'] === 'easy' ? 'selected' : '' ?>>Easy</option>
        <option value="medium" <?= $lesson['difficulty'] === 'medium' ? 'selected' : '' ?>>Medium</option>
        <option value="hard" <?= $lesson['difficulty'] === 'hard' ? 'selected' : '' ?>>Hard</option>
    </select><br>

    <label for="rating">Rating:</label>
    <input id="rating" name="rating" type="number" step="0.01" min="0" max="10" value="<?= $lesson['rating'] ?>"><br>

    <button type="submit" class="btn-submit">Update</button>
</form>