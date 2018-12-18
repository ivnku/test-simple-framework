<?php

namespace TestFramework\tests\Core;

use PHPUnit\Framework\TestCase;
use TestFramework\Core\Router;

final class RouterTest extends TestCase
{

    protected $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function testConvertToStudlyCaps()
    {
        $controller_name = $this->router->convertToStudlyCaps('controller-name');
        $this->assertEquals('ControllerName', $controller_name);
        $controller_name = $this->router->convertToStudlyCaps('controllername');
        $this->assertEquals('Controllername', $controller_name);
        $controller_name = $this->router->convertToStudlyCaps('Controller-Second-Name');
        $this->assertEquals('ControllerSecondName', $controller_name);
    }

    public function testConvertToCamelCase()
    {
        $action_name = $this->router->convertToCamelCase('action-name');
        $this->assertEquals('actionName', $action_name);
        $action_name = $this->router->convertToCamelCase('actionName');
        $this->assertEquals('actionName', $action_name);
        $action_name = $this->router->convertToCamelCase('action-second-name');
        $this->assertEquals('actionSecondName', $action_name);
    }

    public function testRemoveQueryStringVariables()
    {
        // host.ru/posts/add-new?text=smth&name=ivan
        $url = $this->router->removeQueryStringVariables('posts/add-new&text=smth&name=ivan');
        $this->assertEquals('posts/add-new', $url);
        // host.ru/?text=smth
        $url = $this->router->removeQueryStringVariables('text=smth');
        $this->assertEquals('', $url);
    }
}
