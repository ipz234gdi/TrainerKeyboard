<?php /** @var array $lessons, $completed, string $lang */ ?>
<h1>Уроки</h1>

<form method="get" action="/lessons">
  <label>Мова:
    <select name="lang" onchange="this.form.submit()">
      <option value="ua" <?= $lang === 'ua' ? 'selected' : '' ?>>Українська</option>
      <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>English</option>
    </select>
  </label>

  <label>Складність:
    <select name="difficulty" onchange="this.form.submit()">
      <option value="easy" <?= $difficulty === 'easy' ? 'selected' : '' ?>>Легкий</option>
      <option value="medium" <?= $difficulty === 'medium' ? 'selected' : '' ?>>Середній</option>
      <option value="hard" <?= $difficulty === 'hard' ? 'selected' : '' ?>>Важкий</option>
    </select>
  </label>

  <label>Рейтинг від:
    <input type="number" name="minRating" value="<?= htmlspecialchars($minRating) ?>" min="0" max="5" step="0.1"
      onchange="this.form.submit()">
  </label>
</form>

<!-- Поле пошуку -->
<div class="search">
  <input id="lesson-search" type="text" placeholder="Пошук уроків..." autocomplete="off">
</div>

<!-- Контейнер для результатів AJAX -->
<div id="search-results" style="display:none;">
  <h2>Результати пошуку</h2>
  <ul id="results-list"></ul>
</div>

<!-- Початковий список уроків -->
<div id="all-lessons">
  <table>
    <tr>
      <th>№</th>
      <th>Заголовок</th>
      <th>Предпросмотр</th>
      <th>Рейтинг</th>
      <th>Складність</th>
      <th>Статус</th>
      <th>Дія</th>
    </tr>
    <?php foreach ($lessons as $l): ?>
      <tr>
        <td><?= $l['id'] ?></td>
        <td><?= htmlspecialchars($l['title']) ?></td>
        <td><?= htmlspecialchars($l['preview']) ?></td>
        <td><?= $l['rating'] ?></td>
        <td><?= $l['difficulty'] ?></td>
        <td>
          <?php if (in_array($l['id'], $completed)): ?>
            <span>Пройдено</span>
          <?php else: ?>
            <span>Не пройдено</span>
          <?php endif; ?>
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
</div>


<script>
  document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('lesson-search');
    const resultsDiv = document.getElementById('search-results');
    const list = document.getElementById('results-list');
    const allLessons = document.getElementById('all-lessons');
    let timeout;

    input.addEventListener('input', () => {
      clearTimeout(timeout);
      const q = input.value.trim();
      timeout = setTimeout(() => {
        if (q === '') {
          resultsDiv.style.display = 'none';
          allLessons.style.display = '';
          return;
        }
        fetch(`/lessons/search?query=${encodeURIComponent(q)}`)
          .then(res => res.json())
          .then(data => {
            list.innerHTML = '';
            if (data.length === 0) {
              list.innerHTML = '<li>Нічого не знайдено</li>';
            } else {
              data.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = `
                <strong>${item.id}. ${item.title}</strong>
                <p>${item.preview}</p>
                <form method="post" action="/lessons/start" style="display:inline">
                  <input type="hidden" name="lesson_id" value="${item.id}">
                  <input type="hidden" name="lang" value="${item.lang}">
                  <button type="submit">Почати</button>
                </form>
              `;
                list.appendChild(li);
              });
            }
            allLessons.style.display = 'none';
            resultsDiv.style.display = '';
          })
          .catch(console.error);
      }, 300);
    });
  });
</script>