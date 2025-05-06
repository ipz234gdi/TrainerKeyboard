<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Lesson;

class LessonController extends BaseController {
  public function index(): void {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (empty($_SESSION['user_id'])) {
      $this->view('index');
    } else {
      $this->redirect('/lesson');
    }
  }
  public function show(): void {
    session_start(); if (empty($_SESSION['user_id'])) $this->redirect('/');
    $lessons = (new Lesson())->all();
    $this->view('lesson', ['lessons'=>$lessons]);
  }
  public function start(): void {
    session_start(); if (empty($_SESSION['user_id'])) $this->redirect('/');
    $lid = (int)($_POST['lesson_id']??0);
    $wpm = (int)($_POST['wpm']??0);
    $acc = (float)($_POST['accuracy']??0);
    (new \App\Models\Stats())->create($_SESSION['user_id'],$lid,$wpm,$acc);
    $this->redirect('/stats');
  }
}
