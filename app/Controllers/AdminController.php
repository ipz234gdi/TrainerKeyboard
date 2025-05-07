<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Stats;
use App\Models\Category;
use Exception;

class AdminController extends BaseController
{
    private User $userModel;
    private Lesson $lessonModel;
    private Stats $statsModel;
    private Category $categoryModel;

    public function __construct()
    {
        // Перевірка прав доступу, щоб цей контролер міг використовувати лише адмін
        $this->ensureAdmin();
        // Ініціалізація моделей для роботи з базою даних
        $this->userModel = new User();
        $this->lessonModel = new Lesson();
        $this->statsModel = new Stats();
        $this->categoryModel = new Category();
    }

    // Управління уроками
    public function lessonsIndex(): void
    {
        // Завантажуємо всі уроки та категорії
        $lessons = $this->lessonModel->all();
        $categories = $this->categoryModel->all();

        $this->view('admin/lessons/index', [
            'lessons' => $lessons,
            'categories' => $categories
        ]);
    }

    // Форма для створення уроків
    public function lessonsCreateForm(): void
    {
        // Завантажуємо категорії
        $categories = $this->categoryModel->all();
        $this->view('admin/lessons/create', ['categories' => $categories]);
    }

    // Додавання уроку
    public function lessonsStore(): void
    {
        try {
            // Перевірка отриманих даних
            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'content' => trim($_POST['content'] ?? ''),
                'lang' => ($_POST['lang'] === 'en' ? 'en' : 'ua'),
                'category_id' => (int) ($_POST['category_id'] ?? 0),
                'tags' => trim($_POST['tags'] ?? '')
            ];

            if (!$data['title'] || !$data['content']) {
                throw new Exception('Не всі поля заповнені.');
            }

            // Створення нового уроку
            $this->lessonModel->create($data);
            $this->redirect('/admin/lessons');
        } catch (Exception $e) {
            // Логування помилок
            error_log($e->getMessage());
            $this->view('admin/lessons/create', ['error' => 'Сталася помилка. Спробуйте ще раз.']);
        }
    }

    // Редагування уроку
    public function lessonsEditForm(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $lesson = $this->lessonModel->getById($id);
        $categories = $this->categoryModel->all();
        $this->view('admin/lessons/edit', [
            'lesson' => $lesson,
            'categories' => $categories
        ]);
    }

    // Оновлення уроку
    public function lessonsUpdate(): void
    {
        try {
            $id = (int) ($_POST['id'] ?? 0);
            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'content' => trim($_POST['content'] ?? ''),
                'lang' => ($_POST['lang'] === 'en' ? 'en' : 'ua'),
                'category_id' => (int) ($_POST['category_id'] ?? 0),
                'tags' => trim($_POST['tags'] ?? '')
            ];

            if (!$data['title'] || !$data['content']) {
                throw new Exception('Не всі поля заповнені.');
            }

            // Оновлення уроку
            $this->lessonModel->update($id, $data);
            $this->redirect('/admin/lessons');
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->view('admin/lessons/edit', ['error' => 'Сталася помилка. Спробуйте ще раз.']);
        }
    }

    // Видалення уроку
    public function lessonsDestroy(): void
    {
        try {
            $id = (int) ($_POST['id'] ?? 0);
            $this->lessonModel->delete($id);
            $this->redirect('/admin/lessons');
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->view('admin/lessons/index', ['error' => 'Не вдалося видалити урок.']);
        }
    }

    // Управління користувачами
    public function usersIndex(): void
    {
        $users = $this->userModel->all();
        $this->view('admin/users/index', ['users' => $users]);
    }

    // Оновлення ролі користувача
    public function usersUpdateRole(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $role = $_POST['role'] ?? 'student';
        $this->userModel->updateRole($id, $role);
        $this->redirect('/admin/users');
    }

    // Блокування/розблокування користувача
    public function usersToggleBlock(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $current = (int) ($_POST['blocked'] ?? 0);
        $this->userModel->setBlocked($id, !$current);
        $this->redirect('/admin/users');
    }
}
