<?php 

//phpinfo();exit;
// require_once 'core/Application.php';
// require_once 'core/Router.php';

require_once '../vendor/autoload.php';

use app\core\Application;

// print "<pre>";
// var_dump(dirname(__DIR__));
// print "</pre>";
// exit();

$app = new Application(dirname(__DIR__));


$app->router->get('/', 'home');

$app->router->get('/about', 'about');

$app->run();


// $router->get('/about', function() {
//     return "this is about page";
// });

//$app->run();





