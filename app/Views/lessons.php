<?php /** @var array $lessons, $completed, string $lang */ ?>
<h1>Уроки</h1>

<form id="langForm" method="get" action="/lessons">
  <label>Мова:
    <select name="lang" onchange="this.form.submit()">
      <option value="ua" <?= $lang==='ua'?'selected':'' ?>>Українська</option>
      <option value="en" <?= $lang==='en'?'selected':'' ?>>English</option>
    </select>
  </label>
</form>

<!-- 4.1. Поле пошуку -->
<div class="search">
  <input id="lesson-search" type="text" placeholder="Пошук уроків..." autocomplete="off">
</div>

<!-- 4.2. Контейнер для результатів AJAX -->
<div id="search-results" style="display:none;">
  <h2>Результати пошуку</h2>
  <ul id="results-list"></ul>
</div>

<!-- 4.3. Початковий список уроків -->
<div id="all-lessons">
  <table>
    <tr>
      <th>№</th><th>Заголовок</th><th>Прев’ю</th><th>Статус</th><th>Дія</th>
    </tr>
    <?php foreach($lessons as $l): 
      $id      = (int)$l['id'];
      $done    = in_array($id, $completed, true);
      $title   = htmlspecialchars($l['title']);
      $preview = htmlspecialchars(mb_substr($l['content'],0,100)).'…';
    ?>
    <tr>
      <td><?= $id ?></td>
      <td><?= $title ?></td>
      <td><?= nl2br($preview) ?></td>
      <td style="text-align:center"><?= $done?'✔':'–' ?></td>
      <td>
        <form method="get" action="/lesson/show">
          <input type="hidden" name="id" value="<?= $id ?>">
          <button type="submit">Preview</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
