<?php
// Перед викликом цього view ти маєш передати $lesson = ['title' => 'Назва уроку', 'content' => 'текст уроку...']
?>
<header>
    <h1><?= htmlspecialchars($lesson['title'], ENT_QUOTES) ?></h1>
</header>

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
        <div class="toggle">
            <label class="switch">
                <input type="checkbox" id="show-keyboard" checked>
                <span class="slider"></span>
            </label>
            <label for="show-keyboard">Показувати клавіатуру</label>
        </div>
        <button id="reset-btn" class="btn">Почати спочатку</button>
    </div>
</div>
<div class="card">
    <div id="keyboard">
        <!-- Ряд 1 -->
        <div class="key-row">
            <span class="key" data-key="Backquote" data-lang="en">~</span>
            <span class="key" data-key="Digit1" data-lang="en">1</span>
            <span class="key" data-key="Digit2" data-lang="en">2</span>
            <span class="key" data-key="Digit3" data-lang="en">3</span>
            <span class="key" data-key="Digit4" data-lang="en">4</span>
            <span class="key" data-key="Digit5" data-lang="en">5</span>
            <span class="key" data-key="Digit6" data-lang="en">6</span>
            <span class="key" data-key="Digit7" data-lang="en">7</span>
            <span class="key" data-key="Digit8" data-lang="en">8</span>
            <span class="key" data-key="Digit9" data-lang="en">9</span>
            <span class="key" data-key="Digit0" data-lang="en">0</span>
            <span class="key" data-key="Minus" data-lang="en">-</span>
            <span class="key" data-key="Equal" data-lang="en">=</span>
            <span class="key wide" data-key="Backspace" data-lang="en">⌫</span>
            <span class="key" data-key="Backquote" data-lang="ua">~</span>
            <span class="key" data-key="Digit1" data-lang="ua">1</span>
            <span class="key" data-key="Digit2" data-lang="ua">2</span>
            <span class="key" data-key="Digit3" data-lang="ua">3</span>
            <span class="key" data-key="Digit4" data-lang="ua">4</span>
            <span class="key" data-key="Digit5" data-lang="ua">5</span>
            <span class="key" data-key="Digit6" data-lang="ua">6</span>
            <span class="key" data-key="Digit7" data-lang="ua">7</span>
            <span class="key" data-key="Digit8" data-lang="ua">8</span>
            <span class="key" data-key="Digit9" data-lang="ua">9</span>
            <span class="key" data-key="Digit0" data-lang="ua">0</span>
            <span class="key" data-key="Minus" data-lang="ua">-</span>
            <span class="key" data-key="Equal" data-lang="ua">=</span>
            <span class="key wide" data-key="Backspace" data-lang="ua">⌫</span>
        </div>
        <!-- Ряд 2 -->
        <div class="key-row">
            <span class="key wide" data-key="Tab" data-lang="en">Tab</span>
            <span class="key wide" data-key="Tab" data-lang="ua">Tab</span>
            <span class="key" data-key="KeyQ" data-lang="en">Q</span>
            <span class="key" data-key="KeyQ" data-lang="ua">Й</span>
            <span class="key" data-key="KeyW" data-lang="en">W</span>
            <span class="key" data-key="KeyW" data-lang="ua">Ц</span>
            <span class="key" data-key="KeyE" data-lang="en">E</span>
            <span class="key" data-key="KeyE" data-lang="ua">У</span>
            <span class="key" data-key="KeyR" data-lang="en">R</span>
            <span class="key" data-key="KeyR" data-lang="ua">К</span>
            <span class="key" data-key="KeyT" data-lang="en">T</span>
            <span class="key" data-key="KeyT" data-lang="ua">Е</span>
            <span class="key" data-key="KeyY" data-lang="en">Y</span>
            <span class="key" data-key="KeyY" data-lang="ua">Н</span>
            <span class="key" data-key="KeyU" data-lang="en">U</span>
            <span class="key" data-key="KeyU" data-lang="ua">Г</span>
            <span class="key" data-key="KeyI" data-lang="en">I</span>
            <span class="key" data-key="KeyI" data-lang="ua">Ш</span>
            <span class="key" data-key="KeyO" data-lang="en">O</span>
            <span class="key" data-key="KeyO" data-lang="ua">Щ</span>
            <span class="key" data-key="KeyP" data-lang="en">P</span>
            <span class="key" data-key="KeyO" data-lang="ua">З</span>
            <span class="key" data-key="BracketLeft" data-lang="en">[</span>
            <span class="key" data-key="BracketLeft" data-lang="ua">Х</span>
            <span class="key" data-key="BracketRight" data-lang="en">]</span>
            <span class="key" data-key="BracketRight" data-lang="ua">Ї</span>
            <span class="key" data-key="Backslash" data-lang="en">\</span>
            <span class="key" data-key="Backslash" data-lang="ua">/</span>
        </div>
        <!-- Ряд 3 -->
        <div class="key-row">
            <span class="key wide" data-key="CapsLock" data-lang="en">Caps</span>
            <span class="key wide" data-key="CapsLock" data-lang="ua">Caps</span>
            <span class="key" data-key="KeyA" data-lang="en">A</span>
            <span class="key" data-key="KeyA" data-lang="ua">Ф</span>
            <span class="key" data-key="KeyS" data-lang="en">S</span>
            <span class="key" data-key="KeyS" data-lang="ua">І</span>
            <span class="key" data-key="KeyD" data-lang="en">D</span>
            <span class="key" data-key="KeyD" data-lang="ua">В</span>
            <span class="key" data-key="KeyF" data-lang="en">F</span>
            <span class="key" data-key="KeyF" data-lang="ua">А</span>
            <span class="key" data-key="KeyG" data-lang="en">G</span>
            <span class="key" data-key="KeyG" data-lang="ua">П</span>
            <span class="key" data-key="KeyH" data-lang="en">H</span>
            <span class="key" data-key="KeyH" data-lang="ua">Р</span>
            <span class="key" data-key="KeyJ" data-lang="en">J</span>
            <span class="key" data-key="KeyJ" data-lang="ua">О</span>
            <span class="key" data-key="KeyK" data-lang="en">K</span>
            <span class="key" data-key="KeyK" data-lang="ua">Л</span>
            <span class="key" data-key="KeyL" data-lang="en">L</span>
            <span class="key" data-key="KeyL" data-lang="ua">Д</span>
            <span class="key" data-key="Semicolon" data-lang="en">;</span>
            <span class="key" data-key="Semicolon" data-lang="ua">Ж</span>
            <span class="key" data-key="Quote" data-lang="en">'</span>
            <span class="key" data-key="Quote" data-lang="ua">Є</span>
            <span class="key wide" data-key="Enter" data-lang="en">Enter</span>
            <span class="key wide" data-key="Enter" data-lang="ua">Enter</span>
        </div>
        <!-- Ряд 4 -->
        <div class="key-row">
            <span class="key extra-wide" data-key="ShiftLeft" data-lang="en">Shift</span>
            <span class="key extra-wide" data-key="ShiftLeft" data-lang="ua">Shift</span>
            <span class="key" data-key="KeyZ" data-lang="en">Z</span>
            <span class="key" data-key="KeyZ" data-lang="ua">Я</span>
            <span class="key" data-key="KeyX" data-lang="en">X</span>
            <span class="key" data-key="KeyX" data-lang="ua">Ч</span>
            <span class="key" data-key="KeyC" data-lang="en">C</span>
            <span class="key" data-key="KeyC" data-lang="ua">С</span>
            <span class="key" data-key="KeyV" data-lang="en">V</span>
            <span class="key" data-key="KeyV" data-lang="ua">М</span>
            <span class="key" data-key="KeyB" data-lang="en">B</span>
            <span class="key" data-key="KeyB" data-lang="ua">И</span>
            <span class="key" data-key="KeyN" data-lang="en">N</span>
            <span class="key" data-key="KeyN" data-lang="ua">Т</span>
            <span class="key" data-key="KeyM" data-lang="en">M</span>
            <span class="key" data-key="KeyM" data-lang="ua">Ь</span>
            <span class="key" data-key="Comma" data-lang="en">,</span>
            <span class="key" data-key="Comma" data-lang="ua">Б</span>
            <span class="key" data-key="Period" data-lang="en">.</span>
            <span class="key" data-key="Period" data-lang="ua">Ю</span>
            <span class="key" data-key="Slash" data-lang="en">/</span>
            <span class="key" data-key="Slash" data-lang="ua">. ,</span>
            <span class="key extra-wide" data-key="ShiftRight" data-lang="en">Shift</span>
            <span class="key extra-wide" data-key="ShiftRight" data-lang="ua">Shift</span>
        </div>
        <!-- Ряд 5 -->
        <div class="key-row">
            <span class="key wide" data-key="ControlLeft" data-lang="en">Ctrl</span>
            <span class="key wide" data-key="MetaLeft" data-lang="en">Win</span>
            <span class="key wide" data-key="AltLeft" data-lang="en">Alt</span>
            <span class="key space" data-key="Space" data-lang="en">Space</span>
            <span class="key wide" data-key="AltRight" data-lang="en">Alt</span>
            <span class="key wide" data-key="ContextMenu" data-lang="en">Menu</span>
            <span class="key wide" data-key="ControlRight" data-lang="en">Ctrl</span>
            <span class="key wide" data-key="ControlLeft" data-lang="ua">Ctrl</span>
            <span class="key wide" data-key="MetaLeft" data-lang="ua">Win</span>
            <span class="key wide" data-key="AltLeft" data-lang="ua">Alt</span>
            <span class="key space" data-key="Space" data-lang="ua">Space</span>
            <span class="key wide" data-key="AltRight" data-lang="ua">Alt</span>
            <span class="key wide" data-key="ContextMenu" data-lang="ua">Menu</span>
            <span class="key wide" data-key="ControlRight" data-lang="ua">Ctrl</span>
        </div>
    </div>
</div>
</div>

<footer>
    <p>© 2025 Тренажер сліпого друку</p>
</footer>

<script>
    // Передаємо конфіг у глобал
    window.TRAINER_CONFIG = {
      lang: '<?= addslashes($lang) ?>',
      lessonText: <?= json_encode($lesson['content'], JSON_UNESCAPED_UNICODE) ?>,
      lessonId: <?= (int)$lesson['id'] ?>,
    };
  </script>
  <script src="/js/typing-trainer.js"></script>