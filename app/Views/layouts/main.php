<!DOCTYPE html>
<html lang="uk">

<head>
  <meta charset="UTF-8">
  <title>Blind Typing Trainer</title>
  <!-- <link rel="stylesheet" href="/assets/style.css"> -->
  <link rel="stylesheet" href="/assets/lesson.css">
  <link rel="stylesheet" href="/assets/home.css">
  <!-- <link rel="stylesheet" href="/assets/main.css"> -->
  <!-- <link rel="stylesheet" href="/assets/lessons.css"> -->
  <link rel="stylesheet" href="/assets/homepage.css">
  <link rel="stylesheet" href="/assets/admin.css">
  <link rel="stylesheet" href="/assets/profile.css">
  <link rel="stylesheet" href="/assets/stats.css">
  <link rel="stylesheet" href="/assets/create-l.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body>

  <?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  ?>
  <nav class="navbar">
    <div class="navbar-container">
      <a href="/" class="navbar-brand">Головна</a>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <div class="navbar-links">
          <a href="/lessons" class="navbar-link">Уроки</a>
          <a href="/stats" class="navbar-link">Статистика</a>
          <a href="/blind-test" class="navbar-link">Сліпий друк</a>
          <a href="/profile" class="navbar-link">Профіль</a>
          <?php
          $userModel = new \App\Models\User();
          if ($userModel->isAdmin((int) $_SESSION['user_id'])):
            ?>
            <a href="/admin/lessons" class="navbar-link">Управління уроками</a>
            <a href="/admin/users" class="navbar-link">Управління користувачами</a>
          <?php endif; ?>
          <a href="/logout" class="navbar-link logout">Вихід</a>
        </div>
      <?php endif; ?>
    </div>
  </nav>
  <div class="container">
    <?php require $viewFile; ?>
  </div>
</body>

</html>