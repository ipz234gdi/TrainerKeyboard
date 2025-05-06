<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;

class AuthController extends BaseController
{
    public function show(): void
    {
        // показати форму входу/реєстрації
        $this->view('auth');
    }

    public function register(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if (!$username || !$password) {
            $this->view('auth', ['error'=>'Заповніть усі поля']);
            return;
        }
        $m = new User();
        if ($m->exists($username)) {
            $this->view('auth', ['error'=>'Користувач вже існує']);
            return;
        }
        $m->create($username, password_hash($password, PASSWORD_BCRYPT));
        $_SESSION['user_id'] = $m->find($username)['id'];
        $this->redirect('/lessons');
    }

    public function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $m = new User();
        $data = $m->find($username);
        if (!$data || !password_verify($password, $data['password'])) {
            $this->view('auth', ['error'=>'Невірний логін або пароль']);
            return;
        }
        $_SESSION['user_id'] = $data['id'];
        $this->redirect('/lessons');
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
        $this->redirect('/');
    }
}
