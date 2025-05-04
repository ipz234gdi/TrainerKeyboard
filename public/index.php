<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Database;

// Завантажуємо .env
Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

// Підключаємо БД
Database::getInstance();

// Маршрути
$router = new Router();
$router->get('/',             'App\Controllers\PageController@home');
$router->get('/lessons',       'App\Controllers\PageController@lessons');
$router->post('/lessons/start','App\Controllers\PageController@startLesson');

$router->get('/stats',        'App\Controllers\PageController@stats');
$router->post('/stats/create', 'App\Controllers\StatsController@create');

$router->post('/user/register','App\Controllers\UserController@register');
$router->post('/user/login',   'App\Controllers\UserController@login');
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
