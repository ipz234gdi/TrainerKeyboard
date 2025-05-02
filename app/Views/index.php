<h1>Тренер сліпого друку</h1>

<?php if (empty($_SESSION['user_id'])): ?>
  <form method="post" action="/user/register">
    <h2>Реєстрація</h2>
    <input name="username" placeholder="Логін">
    <input name="password" type="password" placeholder="Пароль">
    <button type="submit">Зареєструватися</button>
  </form>

  <form method="post" action="/user/login">
    <h2>Вхід</h2>
    <input name="username" placeholder="Логін">
    <input name="password" type="password" placeholder="Пароль">
    <button type="submit">Увійти</button>
  </form>
<?php else: ?>
  <p>Ви в системі. <a href="/lesson">Почати урок</a></p>
<?php endif; ?>
