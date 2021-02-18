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

$app->router->get('/contact', 'contact');

// we create post path
$app->router->post('/contact', function () {    
    return "Handling contact form Post request";
});

$app->run();


// $router->get('/about', function() {
//     return "this is about page";
// });

//$app->run();





