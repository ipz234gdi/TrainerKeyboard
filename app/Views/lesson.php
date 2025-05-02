<h2>Виберіть урок</h2>
<form method="post" action="/lesson/start">
  <select name="lesson_id">
    <?php foreach($lessons as $l): ?>
      <option value="<?=$l['id']?>"><?=$l['title']?></option>
    <?php endforeach; ?>
  </select>

  <textarea id="content" rows="4" readonly>
<?=htmlspecialchars($lessons[0]['content'])?>
  </textarea>

  <input id="input-area" type="text" placeholder="Набери текст тут">
  <button type="submit">Завершити урок</button>
</form>
<script>
  // Твої JS-функції для підрахунку WPM/точності
</script>
