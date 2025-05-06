<?php
/** @var array $lessons */
/** @var string $lang */
/** @var int[] $completed */
$completed = $completed ?? [];
?>

<h1>Уроки</h1>

<form id="langForm" method="get" action="/lessons">
  <label>Мова:
    <select name="lang" onchange="this.form.submit()">
      <option value="ua" <?= $lang === 'ua' ? 'selected' : '' ?>>Українська</option>
      <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>English</option>
    </select>
  </label>
</form>

<table>
  <tr>
    <th>№</th>
    <th>Заголовок</th>
    <th>Прев’ю</th>
    <th>Статус</th>
    <th>Дія</th>
  </tr>
  <?php foreach ($lessons as $l): ?>
    <?php
    $id = (int) $l['id'];
    $title = htmlspecialchars($l['title']);
    $content = htmlspecialchars(mb_substr($l['content'], 0, 100)) . '…';
    $done = in_array($id, $completed, true);
    ?>
    <tr>
      <td><?= $id ?></td>
      <td><?= $title ?></td>
      <td><?= nl2br($content) ?></td>
      <td style="text-align:center">
        <?= $done ? '<span title="Завершено">✔</span>' : '<span title="Не пройдено">–</span>' ?>
      </td>
      <td>
        <form method="post" action="/lessons/start">
          <input type="hidden" name="lesson_id" value="<?= $id ?>">
          <button type="submit">Перейти до тренажера</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>