<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Stats;

class StatsController extends BaseController {
  public function index(): void {
    session_start(); if (empty($_SESSION['user_id'])) $this->redirect('/');
    $data = (new Stats())->forUser($_SESSION['user_id']);
    $this->view('stats',['data'=>$data]);
  }
}
