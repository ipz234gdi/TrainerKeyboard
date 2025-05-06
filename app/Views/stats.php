<?php
/** @var array $userStats */
/** @var array $allStats */
/** @var array $chartData */
/** @var array $filter */
/** @var array $lessons */
?>
<h2>Фільтри</h2>
<form method="get" action="/stats">
  <label>Від: <input type="date" name="from" value="<?= htmlspecialchars($filter['from'] ?? '') ?>"></label>
  <label>До:  <input type="date" name="to"   value="<?= htmlspecialchars($filter['to']   ?? '') ?>"></label>
  <label>Урок:
    <select name="lesson">
      <option value="0">— усі —</option>
      <?php foreach($lessons as $l): ?>
        <option value="<?= $l['id'] ?>"
           <?= $filter['lessonId']==$l['id']?'selected':'' ?>>
          <?= htmlspecialchars($l['title']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>
  <button type="submit">Застосувати</button>
</form>

<h2>Ваш графік WPM</h2>
<canvas id="wpmChart" width="600" height="300"></canvas>

<h2>Ваша статистика</h2>
<table>
  <tr><th>Урок</th><th>WPM</th><th>Точність</th><th>Дата</th></tr>
  <?php foreach ($userStats as $r): ?>
    <tr>
      <td><?= htmlspecialchars($r['title']) ?></td>
      <td><?= $r['wpm'] ?></td>
      <td><?= $r['accuracy'] ?>%</td>
      <td><?= $r['created_at'] ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<h2>Статистика всіх користувачів</h2>
<table>
  <tr><th>Користувач</th><th>Урок</th><th>WPM</th><th>Точність</th><th>Дата</th></tr>
  <?php foreach ($allStats as $r): ?>
    <tr>
      <td><?= htmlspecialchars($r['username']) ?></td>
      <td><?= htmlspecialchars($r['title']) ?></td>
      <td><?= $r['wpm'] ?></td>
      <td><?= $r['accuracy'] ?>%</td>
      <td><?= $r['created_at'] ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('wpmChart').getContext('2d');
const data = <?= json_encode($chartData, JSON_HEX_TAG) ?>;
new Chart(ctx, {
  type: 'line',
  data: {
    labels: data.map(d => d.date),
    datasets: [{
      label: 'WPM',
      data: data.map(d => d.wpm),
      fill: false,
      tension: 0.1
    }]
  },
  options: {
    scales: {
      x: { title: { display: true, text: 'Дата' } },
      y: { title: { display: true, text: 'WPM' }, beginAtZero: true }
    }
  }
});
</script>
