<?php

namespace App\Controllers;

use App\Core\BaseController;

class BlindTestController extends BaseController
{
    public function index(): void
    {
        $this->view('blind-test');
    }

    public function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $wpm = (int)($_POST['wpm'] ?? 0);
        $accuracy = (float)($_POST['accuracy'] ?? 0);

        // Переадресація на сторінку з результатами
        $this->redirect('/stats');
    }
}
