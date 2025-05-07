<h1>Створити урок</h1>
<form method="post" action="/admin/lessons/store">
    <label>Title:<input name="title"></label><br>
    <label>Content:<textarea name="content"></textarea></label><br>
    <label>Language:
      <select name="lang">
        <option value="ua">Українська</option>
        <option value="en">English</option>
      </select>
    </label><br>
    <label>Category:
        <select name="category_id">
            <option value="0">— без категорії —</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Tags (csv):<input name="tags"></label><br>
    <label>Difficulty:
        <select name="difficulty">
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
    </label><br>
    <label>Rating:<input name="rating" type="number" step="0.01" min="0" max="10"></label><br>
    <button type="submit">Save</button>
</form>
