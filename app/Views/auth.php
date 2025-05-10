<?php /** auth.php */ ?>
<?php if (!empty($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<div class="auth-container">
    <h2>Реєстрація</h2>
    <form method="post" action="/register" class="auth-form">
        <input name="username" type="text" placeholder="Логін" required>
        <input name="password" type="password" placeholder="Пароль" required>
        <button type="submit" class="btn-submit">Зареєструватися</button>
    </form>

    <h2>Вхід</h2>
    <form method="post" action="/login" class="auth-form">
        <input name="username" type="text" placeholder="Логін" required>
        <input name="password" type="password" placeholder="Пароль" required>
        <button type="submit" class="btn-submit">Увійти</button>
    </form>
</div>