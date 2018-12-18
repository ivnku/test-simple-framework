<?php

require_once __DIR__ . '/../vendor/autoload.php';

use TestFramework\App\Controllers\Posts;
use TestFramework\Core\Router;

$router = new Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('posts/{action}', ['controller' => 'Posts']);
$router->add('blog/{controller}/smth/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);


echo "query string= " . $_SERVER['QUERY_STRING'] . "<br/>";
$router->dispatch($_SERVER['QUERY_STRING']);
//$router->removeQueryStringVariables($_SERVER['QUERY_STRING']);

// echo '<pre>';
// var_dump($router->getRoutes());
// echo '</pre>';

// $url = $_SERVER['QUERY_STRING'];

// echo '<br/> request uri:  ' . $_SERVER['REQUEST_URI'] . '<br/>';
// echo 'query string:  ' . $_SERVER['QUERY_STRING'] . '<br/>';

// if($router->match($url)) {
//     print_r($router->getParams());
// } else {
//     echo 'not found!';
// }