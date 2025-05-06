<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Database;

// Завантажуємо .env
Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

// Підключаємо БД
Database::getInstance();

// підключили сесію на старті
session_start();

// Маршрути
$router = new Router();

// сторінка входу/реєстрації
$router->get('/',                'App\Controllers\AuthController@show');
$router->post('/register',       'App\Controllers\AuthController@register');
$router->post('/login',          'App\Controllers\AuthController@login');
$router->get('/logout',          'App\Controllers\AuthController@logout');

$router->get('/lessons',       'App\Controllers\PageController@lessons');
$router->post('/lessons/start','App\Controllers\PageController@startLesson');

$router->get('/stats',        'App\Controllers\PageController@stats');
$router->post('/stats/create', 'App\Controllers\StatsController@create');

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
