<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Blind Typing Trainer</title>
  <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
  <nav>
    <a href="/">Головна</a>
    <?php if(!empty($_SESSION['user_id'])): ?>
      <a href="/lesson">Уроки</a>
      <a href="/stats">Статистика</a>
    <?php endif; ?>
  </nav>
  <div class="container">
    <?php require $viewFile; ?>
  </div>
</body>
</html>
