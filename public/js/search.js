document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("lesson-search");
  const resultsDiv = document.getElementById("search-results");
  const list = document.getElementById("results-list");
  const allLessons = document.getElementById("all-lessons");
  let timeout;

  input.addEventListener("input", () => {
    clearTimeout(timeout);
    const q = input.value.trim();
    timeout = setTimeout(() => {
      if (q === "") {
        resultsDiv.style.display = "none";
        allLessons.style.display = "";
        return;
      }
      fetch(`/lessons/search?query=${encodeURIComponent(q)}`)
        .then((res) => res.json())
        .then((data) => {
          list.innerHTML = "";
          if (data.length === 0) {
            list.innerHTML = "<li>Нічого не знайдено</li>";
          } else {
            data.forEach((item) => {
              const li = document.createElement("li");
              li.innerHTML = `
                <strong>${item.id}. ${item.title}</strong>
                <p>${item.preview}</p>
                <form method="post" action="/lessons/start" style="display:inline">
                  <input type="hidden" name="lesson_id" value="${item.id}">
                  <input type="hidden" name="lang" value="${item.lang}">
                  <button type="submit">Почати</button>
                </form>
              `;
              list.appendChild(li);
            });
          }
          allLessons.style.display = "none";
          resultsDiv.style.display = "";
        })
        .catch(console.error);
    }, 300);
  });
});
