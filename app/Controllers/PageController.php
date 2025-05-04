<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Lesson;
use App\Models\Stats;

class PageController extends BaseController
{
    public function home(): void {
        session_start();
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        // Якщо урок не передано через POST, беремо тестовий текст
        if (!isset($_SESSION['current_lesson'])) {
            $lesson = [
              'id'      => 0,
              'title'   => 'Тестова зона',
              'content' => 'Набирайте будь-який текст для перевірки швидкості та точності друку.'
            ];
        } else {
            // попередній вибраний урок
            $lesson = (new Lesson())->getById($_SESSION['current_lesson']);
        }
        $this->view('home', ['lesson'=>$lesson]);
    }

    public function lessons(): void
    {
        session_start();
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $lessons = (new Lesson())->all();
        $this->view('lessons', ['lessons'=>$lessons]);
    }

    public function startLesson(): void {
        session_start();
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $lid = (int)($_POST['lesson_id'] ?? 0);
        // зберігаємо вибір у сесії
        $_SESSION['current_lesson'] = $lid;
        $lesson = $lid
          ? (new Lesson())->getById($lid)
          : ['id'=>0,'title'=>'Тестова зона','content'=>'Набирайте будь-який текст...'];
        $this->view('home', ['lesson'=>$lesson]);
    }

    public function stats(): void
    {
        session_start();
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $userStats = (new Stats())->forUser($_SESSION['user_id']);
        $allStats  = (new Stats())->allUsersStats();
        $this->view('stats', ['userStats'=>$userStats,'allStats'=>$allStats]);
    }
}
