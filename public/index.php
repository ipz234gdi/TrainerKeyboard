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

$router->get('/admin/lessons',        'App\Controllers\AdminController@lessonsIndex');
$router->get('/admin/lessons/create', 'App\Controllers\AdminController@lessonsCreateForm');
$router->post('/admin/lessons/store', 'App\Controllers\AdminController@lessonsStore');
$router->get('/admin/lessons/edit',   'App\Controllers\AdminController@lessonsEditForm');
$router->post('/admin/lessons/update','App\Controllers\AdminController@lessonsUpdate');
$router->post('/admin/lessons/delete','App\Controllers\AdminController@lessonsDestroy');

$router->get(  '/admin/users',             'App\Controllers\AdminController@usersIndex');
$router->post('/admin/users/update-role', 'App\Controllers\AdminController@usersUpdateRole');
$router->post('/admin/users/toggle-block','App\Controllers\AdminController@usersToggleBlock');

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
