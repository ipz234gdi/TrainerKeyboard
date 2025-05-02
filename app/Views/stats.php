<h2>Твоя статистика</h2>
<table>
  <thead>
    <tr><th>Урок</th><th>WPM</th><th>Точність</th><th>Дата</th></tr>
  </thead>
  <tbody>
    <?php foreach($data as $row): ?>
      <tr>
        <td><?=$row['title']?></td>
        <td><?=$row['wpm']?></td>
        <td><?=$row['accuracy']?>%</td>
        <td><?=$row['created_at']?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
