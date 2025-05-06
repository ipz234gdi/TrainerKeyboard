<?php
// app/Views/lesson-preview.php
/** @var array|null $lesson */
/** @var string $lang */
?>

<?php if (!$lesson): ?>
  <p>Будь ласка, оберіть урок зі списку <a href="/lessons">тут</a>.</p>
<?php else: ?>
  <h1><?= htmlspecialchars($lesson['title_' . $lang]) ?></h1>
  <div class="preview">
    <?= nl2br(htmlspecialchars($lesson['content_' . $lang])) ?>
  </div>
  <form method="post" action="/lessons/start">
    <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
    <button type="submit">Перейти до тренажера</button>
  </form>
<?php endif; ?>
