<?php

namespace App\Services;

use App\Models\Lesson;
use Exception; // Можливо, знадобиться для більш специфічних винятків

class AdminLessonService
{
    private Lesson $lessonModel;

    public function __construct()
    {
        $this->lessonModel = new Lesson();
    }

    /**
     * Створює новий урок.
     * @param array $data Дані для створення уроку.
     * @return bool True у разі успіху, інакше викидає виняток.
     * @throws Exception Якщо створення не вдалося.
     */
    public function createLesson(array $data): bool
    {
        // Тут може бути додаткова бізнес-логіка перед створенням
        if (!$this->lessonModel->create($data)) {
            throw new Exception('Не вдалося створити урок.');
        }
        return true;
    }

    /**
     * Оновлює існуючий урок.
     * @param array $data Дані для оновлення уроку (повинні містити 'id').
     * @return bool True у разі успіху, інакше викидає виняток.
     * @throws Exception Якщо оновлення не вдалося.
     */
    public function updateLesson(array $data): bool
    {
        // Тут може бути додаткова бізнес-логіка перед оновленням
        if (!isset($data['id'])) {
            throw new Exception('ID уроку відсутній для оновлення.');
        }
        if (!$this->lessonModel->update($data)) {
            throw new Exception('Не вдалося оновити урок.');
        }
        return true;
    }
}