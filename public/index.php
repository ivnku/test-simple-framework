<?php

require_once '../App/Controllers/Posts.php';
require_once '../Core/Router.php';

$router = new Router();

$router->add('', ['controller'=>'Home', 'action'=>'index']);
$router->add('posts', ['controller'=>'Posts', 'action'=>'index']);
//$router->add('posts/new', ['controller'=>'Posts', 'action'=>'new']);
$router->add('posts/{action}', ['controller'=>'Posts']);
$router->add('blog/{controller}/smth/{action}');
$router->add('blog/{controller}/{id:\d+}/{action}');


echo "query string= " . $_SERVER['QUERY_STRING'] . "<br/>";
$router->dispatch($_SERVER['QUERY_STRING']);

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