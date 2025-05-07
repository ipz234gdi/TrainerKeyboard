<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\Stats;
use App\Models\User;
use PDO;

class LessonController extends BaseController
{
  private Lesson $lessonModel;
  private Category $categoryModel;
  private Stats $statsModel;

  public function __construct()
  {
    $this->lessonModel = new Lesson();
    $this->categoryModel = new Category();
    $this->statsModel = new Stats();
  }

  // Виведення всіх уроків
  public function index(): void
  {
    $lang = $_GET['lang'] ?? 'ua';
    $difficulty = $_GET['difficulty'] ?? 'medium';
    $minRating = (float) ($_GET['minRating'] ?? 0);

    $lessons = $this->lessonModel->allByLangAndFilters($lang, $difficulty, $minRating);
    $categories = $this->categoryModel->all();

    $this->view('lessons/index', [
      'lessons' => $lessons,
      'categories' => $categories
    ]);
  }

  // Пошук уроків
  public function search(): void
  {
    $q = $_GET['query'] ?? '';
    $lang = $_GET['lang'] ?? 'ua';
    $difficulty = $_GET['difficulty'] ?? 'medium';
    $minRating = (float) ($_GET['minRating'] ?? 0);

    $results = $this->lessonModel->search($q, $lang, $difficulty, $minRating);

    $this->view('lessons/search', ['results' => $results]);
  }

  // Виведення детальної інформації про урок
  public function show($id): void
  {
    $lesson = $this->lessonModel->getById($id);
    $stats = $this->statsModel->forLesson($id);

    $this->view('lessons/show', [
      'lesson' => $lesson,
      'stats' => $stats
    ]);
  }

  // Створення нового уроку
  public function create(): void
  {
    $categories = $this->categoryModel->all();
    $this->view('admin/lessons/create', ['categories' => $categories]);
  }

  // Збереження нового уроку
  public function store(): void
  {
    $data = [
      'title' => trim($_POST['title']),
      'content' => trim($_POST['content']),
      'category_id' => (int) $_POST['category_id'],
      'lang' => $_POST['lang'] ?? 'ua',
      'tags' => trim($_POST['tags'] ?? '')
    ];

    $this->lessonModel->create($data);
    $this->redirect('/lessons');
  }

  // Редагування уроку
  public function edit($id): void
  {
    $lesson = $this->lessonModel->getById($id);
    $categories = $this->categoryModel->all();
    $this->view('admin/lessons/edit', [
      'lesson' => $lesson,
      'categories' => $categories
    ]);
  }

  // Оновлення уроку
  public function update(): void
  {
      $data = [
          'id' => (int) $_POST['id'],
          'title' => trim($_POST['title']),
          'content' => trim($_POST['content']),
          'category_id' => (int) $_POST['category_id'],
          'lang' => $_POST['lang'] ?? 'ua',
          'tags' => trim($_POST['tags'] ?? ''),
          'difficulty' => $_POST['difficulty'] ?? 'medium',  // Додано значення за замовчуванням
          'rating' => $_POST['rating'] ?? 0  // Додано значення за замовчуванням
      ];
  
      $this->lessonModel->update($data);
      $this->redirect('/lessons');
  }
}
