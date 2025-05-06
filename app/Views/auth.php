<?php /** auth.php */ ?>
<?php if (!empty($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<h2>Реєстрація</h2>
<form method="post" action="/register">
    <input name="username" placeholder="Логін" required>
    <input name="password" type="password" placeholder="Пароль" required>
    <button type="submit">Зареєструватися</button>
</form>

<h2>Вхід</h2>
<form method="post" action="/login">
    <input name="username" placeholder="Логін" required>
    <input name="password" type="password" placeholder="Пароль" required>
    <button type="submit">Увійти</button>
</form>