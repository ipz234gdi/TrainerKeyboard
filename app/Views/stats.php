<h2>Ваша статистика</h2>
<table>
  <tr>
    <th>Урок</th>
    <th>WPM</th>
    <th>Точність</th>
    <th>Дата</th>
  </tr>
  <?php foreach ($userStats as $r): ?>
    <tr>
      <td><?= $r['title'] ?></td>
      <td><?= $r['wpm'] ?></td>
      <td><?= $r['accuracy'] ?>%</td>
      <td><?= $r['created_at'] ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<h2>Статистика всіх користувачів</h2>
<table>
  <tr>
    <th>Користувач</th>
    <th>Урок</th>
    <th>WPM</th>
    <th>Точність</th>
    <th>Дата</th>
  </tr>
  <?php foreach ($allStats as $r): ?>
    <tr>
      <td><?= $r['username'] ?></td>
      <td><?= $r['title'] ?></td>
      <td><?= $r['wpm'] ?></td>
      <td><?= $r['accuracy'] ?>%</td>
      <td><?= $r['created_at'] ?></td>
    </tr>
  <?php endforeach; ?>
</table>