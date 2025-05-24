<?php

namespace App\Services;

use App\Models\Lesson;
use App\Models\Stats;

class LessonService
{
    private Lesson $lessonModel;
    private Stats $statsModel;

    public function __construct()
    {
        $this->lessonModel = new Lesson();
        $this->statsModel = new Stats();
    }

    public function getLessonsWithPreviews(int $userId, string $lang = 'ua', string $difficulty = 'medium', float $minRating = 0): array
    {
        // Зберігаємо обрану мову в сесії (викликається з контролера)
        $_SESSION['lang'] = in_array($lang, ['ua', 'en', 'all']) ? $lang : 'ua';

        $lessons = $this->lessonModel->allByLangAndFilters($lang, $difficulty, $minRating);

        $completed = $this->statsModel->completedLessons($userId);

        foreach ($lessons as &$lesson) {
            // Оновлення рейтингу та складності уроку
            $this->lessonModel->updateLessonRating($lesson['id']);
            $this->lessonModel->updateLessonDifficulty($lesson['id']);

            // Додавання прев'ю, якщо воно відсутнє
            if (!isset($lesson['preview'])) {
                $lesson['preview'] = isset($lesson['content'])
                    ? mb_substr($lesson['content'], 0, 100) . '...'
                    : 'Немає попереднього перегляду';
            }
        }

        return [
            'lessons' => $lessons,
            'completed' => $completed
        ];
    }

    public function getLessonOrDefault(int $lessonId): array
    {
        return $lessonId
            ? $this->lessonModel->getById($lessonId)
            : [
                'id' => 0,
                'title' => 'Тестова зона',
                'content' => 'Набирайте будь-який текст для перевірки швидкості та точності друку.'
            ];
    }

    public function getLangOrDefault(int $lessonId): string
    {
        return $this->lessonModel->getLangById($lessonId) ?? 'ua';
    }
    public function getFilteredLessons(string $lang, string $difficulty, float $minRating, int $userId): array
    {
        $lang = in_array($lang, ['ua', 'en', 'all']) ? $lang : 'ua';

        $lessons = $this->lessonModel->allByLangAndFilters($lang, $difficulty, $minRating);
        $completed = $this->statsModel->completedLessons($userId);

        foreach ($lessons as &$lesson) {
            $this->lessonModel->updateLessonRating($lesson['id']);
            $this->lessonModel->updateLessonDifficulty($lesson['id']);

            if (!isset($lesson['preview'])) {
                $lesson['preview'] = isset($lesson['content']) ? mb_substr($lesson['content'], 0, 100) . '...' : 'Немає попереднього перегляду';
            }
        }

        return ['lessons' => $lessons, 'completed' => $completed];
    }

    public function getLessonLang(int $lessonId): string
    {
        return $this->lessonModel->getLangById($lessonId) ?? 'ua';
    }
}
