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
            <span data-key="Backslash">\</span>
        </div>
        <!-- Ряд 3 -->
        <div class="key-row">
            <span data-key="CapsLock" class="wide">Caps</span>
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
            <span data-key="Enter" class="wide">Enter</span>
        </div>
        <!-- Ряд 4 -->
        <div class="key-row">
            <span data-key="ShiftLeft" class="extra-wide">Shift</span>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Динамічні дані з PHP
        const lang = '<?= $lang ?>'; // отримуємо мову з PHP
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

        const keys = {};

        // Зібрали мапу клавіш
        const allKeys = document.querySelectorAll('.key');
        function updateKeyboard() {
            allKeys.forEach(key => {
                const keyLang = key.getAttribute('data-lang');
                if (keyLang === lang) {
                    key.style.display = 'inline-block';  // Показуємо клавіші для поточної мови
                } else {
                    key.style.display = 'none';  // Ховаємо клавіші іншої мови
                }
            });
        }
        updateKeyboard();

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

            // якщо це пробіл
            if (ch === ' ') {
                // тут — data-key="Space"
                keys['Space']?.classList.add('next');
                return;
            }

            console.log(`Character to match: ${ch}`);

            // шукаємо незалежно від регістру
            for (let code in keys) {
                const key = keys[code].textContent.trim();

                const normalizedCh = ch.normalize("NFC");
                const normalizedKey = key.normalize("NFC");

                console.log(`Character to match: ${ch} (Type: ${typeof ch})`);
                console.log(`Checking key: ${key} (Type: ${typeof key})`);

                if (normalizedKey.toLowerCase() === normalizedCh.toLowerCase()) {
                    console.log(`Match found: ${normalizedKey} === ${normalizedCh}`);
                    keys[code].classList.add('next');

                    break;
                }
            }
            console.log(`-----------------------------------}`);
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
                input.disabled = true
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
            input.disabled = false;
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