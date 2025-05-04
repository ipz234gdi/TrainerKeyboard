<h2>Вибір уроку</h2>
<form method="post" action="/lessons/start">
  <select name="lesson_id">
    <?php foreach($lessons as $l): ?>
      <option value="<?=$l['id']?>"><?=$l['title']?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit">Почати обраний урок</button>
</form>
