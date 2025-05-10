<!-- app/Views/blind-typing.php -->
<h1><?= htmlspecialchars($lesson['title'], ENT_QUOTES) ?></h1>

<div class="container main-content">
    <div class="card">
        <div class="stats">
            <div class="stat-box">
                <h3>Швидкість</h3>
                <p id="wpm">0 зн/хв</p>
            </div>
            <div class="stat-box">
                <h3>Точність</h3>
                <p id="accuracy">100%</p>
            </div>
            <div class="stat-box">
                <h3>Час</h3>
                <p id="time">0:00</p>
            </div>
        </div>

        <div class="typing-area">
            <div id="text-display"></div>
            <input id="input-area" type="text"
                placeholder="<?= htmlspecialchars($lesson['content'][0] ?? '', ENT_QUOTES) ?>" autocomplete="off"
                autocorrect="off" autocapitalize="off" spellcheck="false">
        </div>
    </div>
    <div class="settings">
        <div class="difficulty-picker">
            <label for="difficulty">Складність:</label>
            <select id="difficulty">
                <option value="1">Рівень 1</option>
                <option value="2" selected>Рівень 2</option>
                <option value="3">Рівень 3</option>
            </select>
        </div>
        <button id="reset-btn" class="btn">Почати спочатку</button>
    </div>
</div>
