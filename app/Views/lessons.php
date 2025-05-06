<?php
// app/Views/lessons.php
/** @var array $lessons */
/** @var string $lang */
?>
<h1>Уроки</h1>

<form id="langForm" method="get" action="/lessons">
  <label>Мова:
    <select name="lang" onchange="this.form.submit()">
      <option value="ua" <?= $lang==='ua' ? 'selected' : '' ?>>Українська</option>
      <option value="en" <?= $lang==='en' ? 'selected' : '' ?>>English</option>
    </select>
  </label>
</form>

<table>
  <tr>
    <th>Заголовок</th>
    <th>Прев’ю</th>
    <th>Дія</th>
  </tr>
  <?php foreach($lessons as $l): ?>
    <tr>
      <td><?= htmlspecialchars($l['title_' . $lang]) ?></td>
      <td>
        <?= nl2br(htmlspecialchars(
            mb_substr($l['content_' . $lang], 0, 100) . '…'
        )) ?>
      </td>
      <td>
        <form method="post" action="/lessons/start">
          <input type="hidden" name="lesson_id" value="<?= $l['id'] ?>">
          <button type="submit">Почати</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
