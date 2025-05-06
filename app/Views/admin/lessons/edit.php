<h1>Редагувати урок #<?= $lesson['id'] ?></h1>
<form method="post" action="/admin/lessons/update">
    <input type="hidden" name="id" value="<?= $lesson['id'] ?>">
    <label>Title:<input name="title" value="<?= htmlspecialchars($lesson['title']) ?>"></label><br>
    <label>Content:<textarea name="content"><?= htmlspecialchars($lesson['content']) ?></textarea></label><br>
    <label>Category:
        <select name="category_id">
            <option value="0">— без категорії —</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] == $lesson['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <input name="tags" value="<?= htmlspecialchars($lesson['tags'] ?? '') ?>"><br>
    <button type="submit">Update</button>
</form>