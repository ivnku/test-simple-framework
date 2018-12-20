<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use TestFramework\Core\Router;

$router = new Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('posts/{action}', ['controller' => 'Posts']);
$router->add('blog/{controller}/smth/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$router->dispatch($_SERVER['QUERY_STRING']);