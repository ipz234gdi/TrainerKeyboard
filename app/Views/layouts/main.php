<!DOCTYPE html>
<html lang="uk">

<head>
  <meta charset="UTF-8">
  <title>Blind Typing Trainer</title>
  <link rel="stylesheet" href="/assets/style.css">
  <link rel="stylesheet" href="/assets/lesson.css">
  <link rel="stylesheet" href="/assets/home.css">
</head>

<body>
  <?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  ?>
  <nav>
    <a href="/">Головна</a>
    <?php if (!empty($_SESSION['user_id'])): ?>
      <a href="/lessons">Уроки</a>
      <a href="/stats">Статистика</a>
      <a href="/blind-test">Сліпий друк</a>
      <a href="/profile">Профіль</a>
      <?php
      $userModel = new \App\Models\User();
      if ($userModel->isAdmin((int) $_SESSION['user_id'])):
        ?>
        <a href="/admin/lessons">Управління уроками</a>
        <a href="/admin/users">Управління користувачами</a>
      <?php endif; ?>
      <a href="/logout">Вихід</a>
    <?php endif; ?>
  </nav>
  <div class="container">
    <?php require $viewFile; ?>
  </div>
</body>

</html>