<?php 

//phpinfo();exit;
// require_once 'core/Application.php';
// require_once 'core/Router.php';

require_once '../vendor/autoload.php';

use app\controller\SiteController;
use app\core\Application;
use app\core\AuthController;



$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

print "<pre>";
var_dump($config);
print "</pre>";
exit();

$app = new Application(dirname(__DIR__));


$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/about', [SiteController::class, 'about']);
//$app->router->get('/about', 'about');
$app->router->get('/contact', [SiteController::class, 'contact']);
// we create post path
$app->router->post('/contact', [SiteController::class, 'handleContact']);

// routes for login and register
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->run();


// $router->get('/about', function() {
//     return "this is about page";
// });

//$app->run();





