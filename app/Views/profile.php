<?php
// app/views/profile.php

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профіль користувача</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
</head>
<body>
    <header>
        <h1>Профіль користувача</h1>
    </header>

    <div class="profile-container">
        <h2>Ваші уроки та статистика:</h2>
        <table>
            <thead>
                <tr>
                    <th>Урок</th>
                    <th>Швидкість (WPM)</th>
                    <th>Точність (%)</th>
                    <th>Час завершення</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessonStats as $stat): ?>
                    <tr>
                        <td><?= htmlspecialchars($stat['title'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($stat['wpm'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($stat['accuracy'], ENT_QUOTES) ?>%</td>
                        <td><?= htmlspecialchars($stat['created_at'], ENT_QUOTES) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Загальний бал:</h3>
        <p>Середня швидкість: <?= round($averageStats['average_wpm'], 2) ?> зн/хв</p>
        <p>Середня точність: <?= round($averageStats['average_accuracy'], 2) ?>%</p>

        <h3>Доступні уроки:</h3>
        <ul>
            <?php foreach ($lessons as $lesson): ?>
                <li><?= htmlspecialchars($lesson['title'], ENT_QUOTES) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <footer>
        <p>© 2025 Тренажер сліпого друку</p>
    </footer>
</body>
</html>
