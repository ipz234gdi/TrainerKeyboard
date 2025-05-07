<?php
// app/views/profile.php

?>
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
                    <td><?= htmlspecialchars($stat['lesson_title'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($stat['wpm'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars($stat['accuracy'], ENT_QUOTES) ?>%</td>
                    <td><?= htmlspecialchars($stat['created_at'], ENT_QUOTES) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Загальний бал:</h3>
    <p>Середня швидкість:
        <?= isset($averageStats['average_wpm']) ? round($averageStats['average_wpm'], 2) : 'N/A' ?> зн/хв
    </p>
    <p>Середня точність:
        <?= isset($averageStats['average_accuracy']) ? round($averageStats['average_accuracy'], 2) : 'N/A' ?>%
    </p>


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