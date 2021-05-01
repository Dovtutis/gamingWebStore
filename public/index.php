<?php
require_once '../vendor/autoload.php';

use app\controller\SiteController;
use app\core\AuthController;
use app\core\Application;
use app\controller\UserController;
use app\controller\AdminController;
use app\controller\ShoppingCartController;

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

$app->router->get('/main', [SiteController::class, 'mainPage']);

$app->router->get('/userAccount', [UserController::class, 'userAccount']);

$app->router->get('/adminPanel', [AdminController::class, 'adminInferface']);
$app->router->post('/adminPanel', [AdminController::class, 'adminInferface']);

$app->router->post('/updateOrder', [AdminController::class, 'updateOrder']);

$app->router->post('/fetchItems', [SiteController::class, 'fetchItemsByType']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->post('/editUser', [AuthController::class, 'edit']);

$app->router->post('/changePassword', [AuthController::class, 'changePassword']);

$app->router->post('/addToCart', [ShoppingCartController::class, 'addToCart']);

$app->router->get('/item', [SiteController::class, 'singleItem']);

$app->router->get('/shoppingCart', [ShoppingCartController::class, 'shoppingCart']);
$app->router->post('/deleteFromCart', [ShoppingCartController::class, 'deleteFromCart']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->run();