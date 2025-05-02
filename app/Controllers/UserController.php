<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\User;

class UserController extends BaseController {
  public function register(): void {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    if (!$u||!$p) { echo "Заповніть усі поля"; return; }
    $m = new User();
    if ($m->exists($u)) { echo "Такий юзер є"; return; }
    $m->create($u, password_hash($p,PASSWORD_BCRYPT));
    $this->redirect('/');
  }
  public function login(): void {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    $m = new User(); $data = $m->find($u);
    if (!$data||!password_verify($p,$data['password'])) { echo "Логін/пароль хрень"; return; }
    session_start(); $_SESSION['user_id']=$data['id'];
    $this->redirect('/lesson');
  }
}
