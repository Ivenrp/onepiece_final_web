<?php

session_start();

require_once __DIR__ . '/../autoload.php';

use App\Config\Database;
use App\Repository\CharacterRepository;
use App\Repository\UserRepository;
use App\Service\CharacterService;
use App\Service\AuthService;
use App\Controller\CharacterController;
use App\Controller\HomeController;
use App\Controller\AuthController;

// Simple dependency injection
$db = (new Database())->getConnection();

// Controllers
$charController = new CharacterController(new CharacterService(new CharacterRepository($db)));
$authController = new AuthController(new AuthService(new UserRepository($db)));
$homeController = new HomeController();

// Clean Routing Logic
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Auth Middleware Check
$protectedRoutes = [
    '/dashboard',
    '/characters/create',
    '/characters/store',
    '/characters/edit',
    '/characters/update',
    '/characters/delete',
    '/characters/admin-show',
    '/profile',
    '/profile/change-password'
];

if (in_array($requestUri, $protectedRoutes) && !isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

// Router Map
if ($requestUri === '/') {
    $homeController->index();
} elseif ($requestUri === '/dashboard') {
    $charController->dashboard();
} elseif ($requestUri === '/grandline') {
    $homeController->grandline();
} elseif ($requestUri === '/profile') {
    $homeController->profile();
} elseif ($requestUri === '/profile/change-password') {
    $authController->changeProfilePassword();
} elseif ($requestUri === '/login') {
    if ($method === 'POST') $authController->login();
    else $authController->showLogin();
} elseif ($requestUri === '/register') {
    if ($method === 'POST') $authController->register();
    else $authController->showRegister();
} elseif ($requestUri === '/logout') {
    $authController->logout();
} elseif ($requestUri === '/forgot-password') {
    if ($method === 'POST') $authController->processForgotPassword();
    else $authController->showForgotPassword();
} elseif ($requestUri === '/reset-password') {
    if ($method === 'POST') $authController->processResetPassword();
    else $authController->showResetPassword();
} elseif ($requestUri === '/characters') {
    $charController->index();
} elseif ($requestUri === '/characters/show') {
    $charController->show();
} elseif ($requestUri === '/characters/admin-show') {
    $charController->adminShow();
} elseif ($requestUri === '/characters/create') {
    $charController->create();
} elseif ($requestUri === '/characters/store') {
    $charController->store();
} elseif ($requestUri === '/characters/edit') {
    $charController->edit();
} elseif ($requestUri === '/characters/update') {
    $charController->update();
} elseif ($requestUri === '/characters/delete') {
    $charController->destroy();
} else {
    http_response_code(404);
    echo "404 Not Found";
}
