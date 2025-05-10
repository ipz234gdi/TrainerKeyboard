<h1>Створити урок</h1>
<form method="post" action="/admin/lessons/store" class="lesson-form">
    <label for="title">Title:</label>
    <input id="title" name="title" type="text" required><br>

    <label for="content">Content:</label>
    <textarea id="content" name="content" required></textarea><br>

    <label for="lang">Language:</label>
    <select id="lang" name="lang">
        <option value="ua">Українська</option>
        <option value="en">English</option>
    </select><br>

    <label for="category_id">Category:</label>
    <select id="category_id" name="category_id">
        <option value="0">— без категорії —</option>
        <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="tags">Tags (csv):</label>
    <input id="tags" name="tags" type="text"><br>

    <label for="difficulty">Difficulty:</label>
    <select id="difficulty" name="difficulty">
        <option value="easy">Easy</option>
        <option value="medium">Medium</option>
        <option value="hard">Hard</option>
    </select><br>

    <label for="rating">Rating:</label>
    <input id="rating" name="rating" type="number" step="0.01" min="0" max="10"><br>

    <button type="submit" class="btn-submit">Save</button>
</form>


