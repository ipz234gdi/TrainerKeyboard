<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Lesson;
use App\Models\Category;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->ensureAdmin(); // всі методи цього контролера — лише для адміна
    }

    public function lessonsIndex(): void
    {
        $lessons = (new Lesson())->all();
        $categories = (new Category())->all();
        $this->view('admin/lessons/index', [
            'lessons' => $lessons,
            'categories' => $categories
        ]);
    }

    public function lessonsCreateForm(): void
    {
        $categories = (new Category())->all();
        $this->view('admin/lessons/create', ['categories' => $categories]);
    }

    public function lessonsStore(): void
    {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'category_id' => (int) ($_POST['category_id'] ?? 0),
            'tags' => trim($_POST['tags'] ?? '')
        ];
        (new Lesson())->create($data);
        $this->redirect('/admin/lessons');
    }

    public function lessonsEditForm(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $lesson = (new Lesson())->getById($id);
        $categories = (new Category())->all();
        $this->view('admin/lessons/edit', [
            'lesson' => $lesson,
            'categories' => $categories
        ]);
    }

    public function lessonsUpdate(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'category_id' => (int) ($_POST['category_id'] ?? 0),
            'tags' => trim($_POST['tags'] ?? '')
        ];
        (new Lesson())->update($id, $data);
        $this->redirect('/admin/lessons');
    }

    public function lessonsDestroy(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        (new Lesson())->delete($id);
        $this->redirect('/admin/lessons');
    }
}
