<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Lesson;
use App\Models\Stats;

class PageController extends BaseController
{
    public function home(): void
    {

        if (empty($_SESSION['user_id'])) {
            $this->redirect('/');
        }
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
    }

    public function lessons(): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/');
        }

        // поточна мова
        $lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ua');
        $_SESSION['lang'] = in_array($lang, ['ua', 'en']) ? $lang : 'ua';

        // значення складності
        $difficulty = $_GET['difficulty'] ?? 'medium';  // ініціалізація $difficulty

        // значення мінімального рейтингу
        $minRating = (float) ($_GET['minRating'] ?? 0);

        // уроки по мові з фільтрацією
        $lessons = (new Lesson())->allByLangAndFilters($_SESSION['lang'], $difficulty, $minRating);

        // отримати ID вже пройдених уроків
        $stats = new Stats();
        $completed = $stats->completedLessons((int) $_SESSION['user_id']);

        $this->view('lessons', [
            'lessons' => $lessons,
            'lang' => $_SESSION['lang'],
            'completed' => $completed,
            'minRating' => $minRating,  // передаємо значення в вигляд
            'difficulty' => $difficulty  // передаємо значення складності
        ]);
    }

    public function startLesson(): void
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $lid = (int) ($_POST['lesson_id'] ?? 0);
        // зберігаємо вибір у сесії
        $_SESSION['current_lesson'] = $lid;
        // var_dump($lid);
        $lesson = $lid
            ? (new Lesson())->getById($lid)
            : ['id' => 0, 'title' => 'Тестова зона', 'content' => 'Набирайте будь-який текст...'];

        $lang = (new Lesson())->getLangById($lid) ?: 'ua';

        $this->view('home', ['lesson' => $lesson, 'lang' => $lang]);
    }

    public function stats(): void
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $userStats = (new Stats())->forUser($_SESSION['user_id']);
        $allStats = (new Stats())->allUsersStats();
        $this->view('stats', ['userStats' => $userStats, 'allStats' => $allStats]);
    }
}
