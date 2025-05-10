<?php
/** @var array $userStats */
/** @var array $allStats */
/** @var array $chartData */
/** @var array $filter */
/** @var array $lessons */
?>
<div class="stats-container">
  <!-- Фільтри -->
  <div class="filters">
    <h2>Фільтри</h2>
    <form method="get" action="/stats">
      <div class="filter-item">
        <label for="from">Від:</label>
        <input type="date" name="from" id="from" value="<?= htmlspecialchars($filter['from'] ?? '') ?>">
      </div>
      <div class="filter-item">
        <label for="to">До:</label>
        <input type="date" name="to" id="to" value="<?= htmlspecialchars($filter['to'] ?? '') ?>">
      </div>
      <div class="filter-item">
        <label for="lesson">Урок:</label>
        <select name="lesson" id="lesson">
          <option value="0">— усі —</option>
          <?php foreach($lessons as $l): ?>
            <option value="<?= $l['id'] ?>" <?= $filter['lessonId']==$l['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($l['title']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn-apply">Застосувати</button>
    </form>
  </div>

  <!-- Графік WPM -->
  <div class="chart-container">
    <h2>Ваш графік WPM</h2>
    <canvas id="wpmChart" width="600" height="300"></canvas>
  </div>

  <!-- Статистика користувача -->
  <div class="user-stats">
    <h2>Ваша статистика</h2>
    <table class="stats-table">
      <thead>
        <tr>
          <th>Урок</th>
          <th>WPM</th>
          <th>Точність</th>
          <th>Дата</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($userStats as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['title']) ?></td>
            <td><?= $r['wpm'] ?></td>
            <td><?= $r['accuracy'] ?>%</td>
            <td><?= $r['created_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Статистика всіх користувачів -->
  <div class="all-users-stats">
    <h2>Статистика всіх користувачів</h2>
    <table class="stats-table">
      <thead>
        <tr>
          <th>Користувач</th>
          <th>Урок</th>
          <th>WPM</th>
          <th>Точність</th>
          <th>Дата</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($allStats as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['username']) ?></td>
            <td><?= htmlspecialchars($r['title']) ?></td>
            <td><?= $r['wpm'] ?></td>
            <td><?= $r['accuracy'] ?>%</td>
            <td><?= $r['created_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

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
