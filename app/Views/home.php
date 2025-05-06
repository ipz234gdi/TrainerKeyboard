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
            <span data-key="Backquote">~</span>
            <span data-key="Digit1">1</span>
            <span data-key="Digit2">2</span>
            <span data-key="Digit3">3</span>
            <span data-key="Digit4">4</span>
            <span data-key="Digit5">5</span>
            <span data-key="Digit6">6</span>
            <span data-key="Digit7">7</span>
            <span data-key="Digit8">8</span>
            <span data-key="Digit9">9</span>
            <span data-key="Digit0">0</span>
            <span data-key="Minus">-</span>
            <span data-key="Equal">=</span>
            <span data-key="Backspace" class="wide">⌫</span>
        </div>
        <!-- Ряд 2 -->
        <div class="key-row">
            <span data-key="Tab" class="wide">Tab</span>
            <span data-key="KeyQ">Q</span>
            <span data-key="KeyW">W</span>
            <span data-key="KeyE">E</span>
            <span data-key="KeyR">R</span>
            <span data-key="KeyT">T</span>
            <span data-key="KeyY">Y</span>
            <span data-key="KeyU">U</span>
            <span data-key="KeyI">I</span>
            <span data-key="KeyO">O</span>
            <span data-key="KeyP">P</span>
            <span data-key="BracketLeft">[</span>
            <span data-key="BracketRight">]</span>
            <span data-key="Backslash">\</span>
        </div>
        <!-- Ряд 3 -->
        <div class="key-row">
            <span data-key="CapsLock" class="wide">Caps</span>
            <span data-key="KeyA">A</span>
            <span data-key="KeyS">S</span>
            <span data-key="KeyD">D</span>
            <span data-key="KeyF">F</span>
            <span data-key="KeyG">G</span>
            <span data-key="KeyH">H</span>
            <span data-key="KeyJ">J</span>
            <span data-key="KeyK">K</span>
            <span data-key="KeyL">L</span>
            <span data-key="Semicolon">;</span>
            <span data-key="Quote">'</span>
            <span data-key="Enter" class="wide">Enter</span>
        </div>
        <!-- Ряд 4 -->
        <div class="key-row">
            <span data-key="ShiftLeft" class="extra-wide">Shift</span>
            <span data-key="KeyZ">Z</span>
            <span data-key="KeyX">X</span>
            <span data-key="KeyC">C</span>
            <span data-key="KeyV">V</span>
            <span data-key="KeyB">B</span>
            <span data-key="KeyN">N</span>
            <span data-key="KeyM">M</span>
            <span data-key="Comma">,</span>
            <span data-key="Period">.</span>
            <span data-key="Slash">/</span>
            <span data-key="ShiftRight" class="extra-wide">Shift</span>
        </div>
        <!-- Ряд 5 -->
        <div class="key-row">
            <span data-key="ControlLeft" class="wide">Ctrl</span>
            <span data-key="MetaLeft" class="wide">Win</span>
            <span data-key="AltLeft" class="wide">Alt</span>
            <span data-key="Space" class="space">Space</span>
            <span data-key="AltRight" class="wide">Alt</span>
            <span data-key="ContextMenu" class="wide">Menu</span>
            <span data-key="ControlRight" class="wide">Ctrl</span>
        </div>
    </div>
</div>
</div>

<footer>
    <p>© 2025 Тренажер сліпого друку</p>
</footer>

<style>
    .card {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .stats {
        display: flex;
        justify-content: space-around;
        margin-bottom: 15px;
    }

    .stat-box h3 {
        margin: 0 0 5px;
        font-size: 1em;
    }

    .typing-area {
        margin-bottom: 15px;
    }

    #text-display {
        font-size: 1.2em;
        margin-bottom: 10px;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    #input-area {
        width: 100%;
        padding: 8px;
        font-size: 1em;
        box-sizing: border-box;
    }

    #keyboard {
        user-select: none;
    }

    .key-row {
        display: flex;
        justify-content: center;
        margin-bottom: 5px;
    }

    #keyboard span {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        border: 1px solid #555;
        margin: 0 2px;
        border-radius: 4px;
        background: #eee;
        transition: background .1s;
    }

    #keyboard span.wide {
        width: 60px;
    }

    #keyboard span.extra-wide {
        width: 80px;
    }

    #keyboard span.space {
        width: 200px;
    }

    #keyboard span.active {
        background: #8f8;
    }

    #keyboard span.wrong {
        background: #f88;
    }

    #keyboard span.next {
        background: #88f !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Динамічні дані з PHP
        const lessonText = <?= json_encode($lesson['content'], JSON_HEX_TAG) ?>;
        const lessonId = <?= (int) $lesson['id'] ?>;

        // Елементи UI
        const input = document.getElementById('input-area');
        const display = document.getElementById('text-display');
        const keyboard = document.getElementById('keyboard');
        const resetBtn = document.getElementById('reset-btn');
        const showKbCheck = document.getElementById('show-keyboard');

        const wpmEl = document.getElementById('wpm');
        const accEl = document.getElementById('accuracy');
        const timeEl = document.getElementById('time');


        // Зібрали мапу клавіш
        const keys = {};
        document.querySelectorAll('#keyboard span').forEach(el => {
            keys[el.dataset.key] = el;
        });

        let pos = 0, correct = 0, total = 0, startTime = null, timer = null;
        const levelSelect = document.getElementById('difficulty');

        function clearNextHighlights() {
            document.querySelectorAll('#keyboard span.next')
                .forEach(el => el.classList.remove('next'));
        }
        function clearPressHighlights() {
            document.querySelectorAll('#keyboard span.active, #keyboard span.wrong')
                .forEach(el => el.classList.remove('active', 'wrong'));
        }
        function resetHighlights() {
            clearNextHighlights();
            clearPressHighlights();
        }

        // Підсвічування наступної клавіші (рівень 1)
        function highlightNextKey() {
            const ch = lessonText[pos];

            if (!ch) return;
            // шукаємо незалежно від регістру
            for (let code in keys) {
                if (keys[code].textContent.toLowerCase() === ch.toLowerCase()) {
                    keys[code].classList.add('next');
                    
                    break;
                }
            }
        }

        // Рендер тексту згідно складності
        function renderText() {
            const level = levelSelect.value;

            if (level === '3') {
                display.innerHTML = lessonText[pos]
                    ? `<span class="current">${lessonText[pos]}</span>`
                    : '';
            } else {
                // повний текст із відмітками
                let html = '';
                for (let i = 0; i < lessonText.length; i++) {
                    const ch = lessonText[i];
                    if (i < pos) html += `<span class="correct">${ch}</span>`;
                    else if (i === pos) html += `<span class="current">${ch}</span>`;
                    else html += ch;
                }
                display.innerHTML = html;
            }

            // оновлюємо клавіатуру
            if (level === '1') {
                highlightNextKey();
            }
        }

        // Почати таймер
        function startTimer() {
            startTime = Date.now();
            timer = setInterval(updateStats, 1000);
        }

        // Оновлення статистики
        function updateStats() {
            const elapsed = (Date.now() - startTime) / 1000;
            const minutes = elapsed / 60;
            const wpm = minutes > 0 ? Math.round((correct / 5) / minutes) : 0;
            wpmEl.textContent = `${wpm} зн/хв`;
            const acc = total > 0 ? Math.round((correct / total) * 100) : 100;
            accEl.textContent = `${acc}%`;
            const mins = Math.floor(elapsed / 60);
            const secs = Math.floor(elapsed % 60).toString().padStart(2, '0');
            timeEl.textContent = `${mins}:${secs}`;
        }

        // Обробник натискання клавіш
        input.addEventListener('keydown', e => {
            const level = levelSelect.value;
            resetHighlights();
            if (!startTime && e.key.length === 1) startTimer();

            // Обробка Backspace
            if (e.key === 'Backspace') {
                e.preventDefault();
                if (pos > 0) pos--;
                // для рівнів 2 і 3 прибираємо попередню pressed-підсвітку
                if (level === '2' || level === '3') clearPressHighlights();
                renderText();
                return;
            }
            if (e.key.length !== 1) return;
            e.preventDefault();

            const expected = lessonText[pos];
            total++;

            // додаємо active/wrong для всіх рівнів
            if (e.key === expected) {
                pos++; correct++;
                keys[e.code]?.classList.add('active');
            } else {
                keys[e.code]?.classList.add('wrong');
            }

            renderText();
            updateStats();

            if (pos >= lessonText.length) {
                clearInterval(timer);
                input.placeholder = 'Урок завершено!';
                input.value = '';

                // Відправка статистики
                if (lessonId > 0) {
                    fetch('/stats/create', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            lesson_id: lessonId,
                            wpm: parseInt(wpmEl.textContent),
                            accuracy: parseFloat(accEl.textContent)
                        })
                    });
                }
            }
        });



        // Кнопка “Почати спочатку”
        resetBtn.addEventListener('click', () => {
            clearInterval(timer);
            pos = correct = total = 0;
            startTime = null;
            wpmEl.textContent = '0 зн/хв';
            accEl.textContent = '100%';
            timeEl.textContent = '0:00';
            resetHighlights();
            renderText();
            input.focus();
        });

        // Зміна рівня складності
        levelSelect.addEventListener('change', () => {
            resetHighlights();
            renderText();
            input.focus();
        });

        // Показ/приховування клавіатури
        showKbCheck.addEventListener('change', () => {
            keyboard.style.opacity = showKbCheck.checked ? '1' : '0';
        });

        // Перший рендер і фокус
        renderText();
        input.focus();
    });
</script>