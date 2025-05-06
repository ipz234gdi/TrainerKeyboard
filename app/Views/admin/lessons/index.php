<h1>Управління уроками</h1>
<a href="/admin/lessons/create">+ Додати урок</a>
<table>
    <tr>
        <th>ID</th>
        <th>Заголовок</th>
        <th>Категорія</th>
        <th>Теги</th>
        <th>Дії</th>
    </tr>
    <?php foreach ($lessons as $l): ?>
        <tr>
            <td><?= $l['id'] ?></td>
            <td><?= htmlspecialchars($l['title']) ?></td>
            <td><?= htmlspecialchars($l['category'] ?? '-') ?></td>
            <td><?= htmlspecialchars($l['tags'] ?? '-') ?></td>
            <td>
                <a href="/admin/lessons/edit?id=<?= $l['id'] ?>">Edit</a>
                <form method="post" action="/admin/lessons/delete" style="display:inline">
                    <input type="hidden" name="id" value="<?= $l['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>