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
$router->get('/',             'App\Controllers\LessonController@index');
$router->get('/lesson',       'App\Controllers\LessonController@show');
$router->post('/lesson/start','App\Controllers\LessonController@start');
$router->get('/stats',        'App\Controllers\StatsController@index');
$router->post('/user/register','App\Controllers\UserController@register');
$router->post('/user/login',   'App\Controllers\UserController@login');
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
