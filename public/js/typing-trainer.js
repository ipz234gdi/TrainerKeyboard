// typing-trainer.js
document.addEventListener("DOMContentLoaded", () => {
  class Trainer {
    constructor({ lang, lessonText, lessonId }) {
      this.lang = lang;
      this.chars = [...lessonText];
      this.lessonId = lessonId;
      this.pos = 0;
      this.correct = 0;
      this.total = 0;
      this.startTime = null;
      this.timer = null;

      this.cacheElements();
      this.bindEvents();

      // Синхронізуємо CapsLock на будь-якій клавіші
      document.addEventListener("keydown", this.syncCapsLock.bind(this));
      document.addEventListener("keyup", this.syncCapsLock.bind(this));

      this.updateKeyboardLayout();
      this.render();
      this.input.focus();

      this.syncCapsLock(new KeyboardEvent('keydown'));
    }

    cacheElements() {
      this.input = document.getElementById("input-area");
      this.display = document.getElementById("text-display");
      this.keyboard = document.getElementById("keyboard");
      this.resetBtn = document.getElementById("reset-btn");
      this.showKbChk = document.getElementById("show-keyboard");
      this.levelSelect = document.getElementById("difficulty");
      this.wpmEl = document.getElementById("wpm");
      this.accEl = document.getElementById("accuracy");
      this.timeEl = document.getElementById("time");
      this.keys = Array.from(document.querySelectorAll(".key"));
    }

    bindEvents() {
      this.input.addEventListener("keydown", this.onKeyDown.bind(this));
      this.resetBtn.addEventListener("click", this.reset.bind(this));
      this.levelSelect.addEventListener(
        "change",
        this.onLevelChange.bind(this)
      );
      this.showKbChk.addEventListener(
        "change",
        this.onToggleKeyboard.bind(this)
      );
    }

    updateKeyboardLayout() {
      this.keys.forEach((key) => {
        key.style.display = key.dataset.lang === this.lang ? "" : "none";
      });
      this.onToggleKeyboard();
    }

    onToggleKeyboard() {
      this.keyboard.style.opacity = this.showKbChk.checked ? "1" : "0";
    }

    onLevelChange() {
      this.clearHighlights();
      this.render();
      this.input.focus();
    }

    startTimer() {
      this.startTime = Date.now();
      this.timer = setInterval(() => this.updateStats(), 1000);
    }
    stopTimer() {
      clearInterval(this.timer);
    }

    syncCapsLock(e) {
      // перевіряємо стан CapsLock у цій події
      const isOn = e.getModifierState("CapsLock");
      // знаходимо елемент CapsLock саме для поточної мови
      const capsEl = this.keys.find(
        (k) => k.dataset.key === "CapsLock" && k.dataset.lang === this.lang
      );
      if (!capsEl) return;
      // додаємо/забираємо клас
      capsEl.classList.toggle("lock-on", isOn);
    }

    updateStats() {
      const elapsed = (Date.now() - this.startTime) / 1000;
      const minutes = elapsed / 60 || 1 / 60;
      const wpm = Math.round(this.correct / 5 / minutes);
      this.wpmEl.textContent = `${wpm} зн/хв`;

      const acc = this.total
        ? Math.round((this.correct / this.total) * 100)
        : 100;
      this.accEl.textContent = `${acc}%`;

      const m = Math.floor(elapsed / 60),
        s = String(Math.floor(elapsed % 60)).padStart(2, "0");
      this.timeEl.textContent = `${m}:${s}`;
    }

    onKeyDown(e) {
      const level = this.levelSelect.value;
      const expected = this.chars[this.pos];

      const keyEl = this.keys.find(
        (k) => k.dataset.key === e.code && k.dataset.lang === this.lang
      );

      if (
        e.key === "Shift" &&
        expected.toUpperCase() === expected &&
        expected.toLowerCase() !== expected
      ) {
        e.preventDefault();
        const keyEl = this.keys.find(
          (k) => k.dataset.key === e.code && k.dataset.lang === this.lang
        );
        if (keyEl) keyEl.classList.add("active");
        return;
      }

      this.clearHighlights();

      if (!this.startTime && e.key.length === 1) this.startTimer();

      if (e.key === "Backspace") {
        e.preventDefault();
        if (this.pos > 0) this.pos--;
        this.render();
        return;
      }
      if (e.key === "CapsLock") return;

      e.preventDefault();
      this.total++;

      if (e.key === expected) {
        this.pos++;
        this.correct++;
        if (keyEl) keyEl.classList.add("active");
      } else {
        if (keyEl) keyEl.classList.add("wrong");
      }

      this.render();
      this.updateStats();

      if (this.pos >= this.chars.length) this.onComplete();
    }

    render() {
      const level = this.levelSelect.value;
      if (level === "3") {
        this.display.innerHTML = this.chars[this.pos]
          ? `<span class="current">${this.chars[this.pos]}</span>`
          : "";
      } else {
        this.display.innerHTML = this.chars
          .map((ch, i) => {
            if (i < this.pos) return `<span class="correct">${ch}</span>`;
            if (i === this.pos) return `<span class="current">${ch}</span>`;
            return ch;
          })
          .join("");
      }
      if (level === "1") this.highlightNextKey();

      this.input.placeholder = this.chars[this.pos] || "";
    }

    highlightNextKey() {
      const ch = this.chars[this.pos];
      if (!ch) return;
      let keyEl;
      if (ch === " ") {
        keyEl = this.keyboard.querySelector(
          `.key[data-key="Space"][data-lang="${this.lang}"]`
        );
      } else {
        keyEl = this.keys.find(
          (k) =>
            k.dataset.lang === this.lang &&
            k.textContent.trim().toLowerCase() === ch.toLowerCase()
        );
      }
      if (keyEl) keyEl.classList.add("next");
    }

    clearHighlights() {
      this.keys.forEach((k) => k.classList.remove("next", "active", "wrong"));
    }

    onComplete() {
      this.stopTimer();
      this.input.disabled = true;
      this.input.placeholder = "Урок завершено!";
      this.sendStats();
    }

    sendStats() {
      if (this.lessonId <= 0) return;
      fetch("/stats/create", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          lesson_id: this.lessonId,
          wpm: parseInt(this.wpmEl.textContent),
          accuracy: parseFloat(this.accEl.textContent),
        }),
      });
    }

    reset() {
      this.stopTimer();
      this.pos = this.correct = this.total = 0;
      this.startTime = null;
      this.input.disabled = false;
      this.input.value = "";
      this.input.placeholder = "";
      this.wpmEl.textContent = "0 зн/хв";
      this.accEl.textContent = "100%";
      this.timeEl.textContent = "0:00";
      this.clearHighlights();
      this.render();
      this.input.focus();
    }
  }

  new Trainer(window.TRAINER_CONFIG);
});
