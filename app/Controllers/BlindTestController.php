<?php

namespace App\Controllers;

use App\Core\BaseController;

class BlindTestController extends BaseController
{
    public function start(): void
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        // Статичні дані для уроку
        $lesson = [
            'id' => 1, 
            'title' => 'Тестовий урок для сліпого друку',
            'content' => 'Це статичний текст для уроку. Набирайте його без помилок.'
        ];
    
        // Збереження уроку в сесії (якщо потрібно, для подальшої навігації або статистики)
        $_SESSION['current_lesson'] = $lesson['id'];
        $lang = 'ua';
        // Відправка даних на сторінку
        $this->view('home', ['lesson' => $lesson, 'lang' => $lang]);
    }
}
