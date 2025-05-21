<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Lesson;
use App\Models\Stats;
use App\Core\Middleware\AuthMiddleware;

class PageController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        // Apply auth middleware to all methods except those that don't need authentication
    }

    public function home(): void
    {
        $this->addMiddleware(new AuthMiddleware($this));
        $this->executeAction(function() {
            // No need for authentication check - middleware handles it
            // Якщо урок не передано через POST, беремо тестовий текст
            if (!isset($_SESSION['current_lesson'])) {
                $lesson = [
                    'id' => 0,
                    'title' => 'Тестова зона',
                    'content' => 'Набирайте будь-який текст для перевірки швидкості та точності друку.'
                ];
            } else {
                // попередній вибраний урок
                $lesson = (new Lesson())->getById($_SESSION['current_lesson']);
            }
            $this->view('home', ['lesson' => $lesson]);
        });
    }

    public function lessons(): void
    {
        $this->addMiddleware(new AuthMiddleware($this));
        $this->executeAction(function() {
            // No need for session start - middleware handles it
            // No need for authentication check - middleware handles it

            // Поточна мова
            $lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ua');
            $_SESSION['lang'] = in_array($lang, ['ua', 'en', 'all']) ? $lang : 'ua';

            // Значення складності (за замовчуванням "medium")
            $difficulty = $_GET['difficulty'] ?? 'medium';

            // Значення мінімального рейтингу
            $minRating = (float) ($_GET['minRating'] ?? 0);

            // Отримуємо уроки по мові та фільтраціях
            $lessons = (new Lesson())->allByLangAndFilters($lang, $difficulty, $minRating);

            // Отримуємо ID вже пройдених уроків
            $stats = new Stats();
            $completed = $stats->completedLessons((int) $_SESSION['user_id']);

            // Оновлюємо рейтинг та складність для кожного уроку
            foreach ($lessons as $lesson) {
                // Оновлюємо рейтинг і складність для кожного уроку
                (new Lesson())->updateLessonRating($lesson['id']);
                (new Lesson())->updateLessonDifficulty($lesson['id']);
            }

            // Для кожного уроку перевіряємо наявність "preview" та додаємо значення, якщо його немає
            foreach ($lessons as &$lesson) {
                // Якщо preview відсутній, формуємо його як частину контенту
                if (!isset($lesson['preview'])) {
                    $lesson['preview'] = isset($lesson['content']) ? substr($lesson['content'], 0, 100) . '...' : 'Немає попереднього перегляду';
                }
            }

            // Відправляємо дані на вигляд
            $this->view('lessons', [
                'lessons' => $lessons,
                'lang' => $_SESSION['lang'],
                'completed' => $completed,
                'minRating' => $minRating,
                'difficulty' => $difficulty
            ]);
        });
    }


    public function startLesson(): void
    {
        $this->addMiddleware(new AuthMiddleware($this));
        $this->executeAction(function() {
            // No need for authentication check - middleware handles it
            $lid = (int) ($_POST['lesson_id'] ?? 0);
            // зберігаємо вибір у сесії
            $_SESSION['current_lesson'] = $lid;
            // var_dump($lid);
            $lesson = $lid
                ? (new Lesson())->getById($lid)
                : ['id' => 0, 'title' => 'Тестова зона', 'content' => 'Набирайте будь-який текст...'];

            $lang = (new Lesson())->getLangById($lid) ?: 'ua';

            $this->view('home', ['lesson' => $lesson, 'lang' => $lang]);
        });
    }

    public function stats(): void
    {
        $this->addMiddleware(new AuthMiddleware($this));
        $this->executeAction(function() {
            // No need for authentication check - middleware handles it
            $userStats = (new Stats())->forUser($_SESSION['user_id']);
            $allStats = (new Stats())->allUsersStats();
            $this->view('stats', ['userStats' => $userStats, 'allStats' => $allStats]);
        });
    }
}