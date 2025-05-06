<?php
/** @var array|null $lesson */
/** @var string $lang */
?>

<?php if (!$lesson): ?>
  <p>Будь ласка, оберіть урок зі списку <a href="/lessons">тут</a>.</p>
<?php else: ?>
  <?php
    // ключі з урахуванням мови
    $tKey = 'title_'   . $lang;
    $cKey = 'content_' . $lang;

    // fallback на звичайні title/content
    $title   = htmlspecialchars($lesson[$tKey]   ?? $lesson['title']   ?? '');
    $content = htmlspecialchars($lesson[$cKey] ?? $lesson['content'] ?? '');
  ?>
  <h1><?= $title ?></h1>
  <div class="preview">
    <?= nl2br($content) ?>
  </div>
  <form method="post" action="/lessons/start">
    <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">
    <button type="submit">Перейти до тренажера</button>
  </form>
<?php endif; ?>
