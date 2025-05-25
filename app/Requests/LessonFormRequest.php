<?php

namespace App\Requests;

use Exception;

class LessonFormRequest
{
    private array $data;
    private array $errors = [];

    public function __construct()
    {
        // Отримуємо і очищаємо дані з POST
        $this->data = [
            'title' => trim($_POST['title'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'lang' => $_POST['lang'] === 'en' ? 'en' : 'ua',
            'category_id' => (int) ($_POST['category_id'] ?? 0),
            'tags' => trim($_POST['tags'] ?? ''),
            'difficulty' => $_POST['difficulty'] ?? 'medium',
            'rating' => (float) ($_POST['rating'] ?? 0) // Переконаємось, що це float
        ];

        // Додаємо ID, якщо він присутній (для оновлення)
        if (isset($_POST['id'])) {
            $this->data['id'] = (int) ($_POST['id'] ?? 0);
        }
    }

    /**
     * Валідує дані запиту.
     * @return bool Повертає true, якщо дані валідні, false - в іншому випадку.
     */
    public function validate(): bool
    {
        $this->errors = []; // Очищаємо попередні помилки

        if (empty($this->data['title'])) {
            $this->errors['title'] = 'Назва уроку є обов\'язковою.';
        }
        if (empty($this->data['content'])) {
            $this->errors['content'] = 'Зміст уроку є обов\'язковим.';
        }
        // Додайте інші правила валідації за необхідності
        if (!in_array($this->data['lang'], ['ua', 'en'])) {
            $this->errors['lang'] = 'Некоректна мова.';
        }
        if ($this->data['category_id'] <= 0) {
            $this->errors['category_id'] = 'Категорія не обрана.';
        }
        // Перевірка складності
        if (!in_array($this->data['difficulty'], ['easy', 'medium', 'hard'])) {
            $this->errors['difficulty'] = 'Некоректна складність.';
        }
        // Перевірка рейтингу
        if ($this->data['rating'] < 0 || $this->data['rating'] > 5) {
            $this->errors['rating'] = 'Рейтинг повинен бути від 0 до 5.';
        }


        return empty($this->errors);
    }

    /**
     * Повертає всі дані запиту.
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Повертає помилки валідації.
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Повертає першу помилку валідації або null, якщо помилок немає.
     * @return string|null
     */
    public function getFirstError(): ?string
    {
        return !empty($this->errors) ? reset($this->errors) : null;
    }
}