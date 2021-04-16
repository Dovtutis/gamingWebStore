<?php
require_once '../vendor/autoload.php';

use app\controller\SiteController;
use app\core\AuthController;
use app\core\Application;
use app\controller\FeedbackController;
use app\controller\UserController;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'mainPage']);
$app->router->get('/userAccount', [UserController::class, 'userAccount']);

// $app->router->get('/feedback', [FeedbackController::class, 'index']);
// $app->router->get('/feedback/getComments', [SiteController::class, 'notFound']);
// $app->router->post('/feedback/getComments', [FeedbackController::class, 'getComments']);
// $app->router->post('/feedback/addComment', [FeedbackController::class, 'addComment']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->post('/editUser', [AuthController::class, 'edit']);
$app->router->post('/changePassword', [AuthController::class, 'changePassword']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->run();