<?php

namespace Enkelad\TestFramework\Core;

abstract class Controller
{
    protected $route_params = [];

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            echo "Method $method not found in the controller" . get_class($this);
        }
    }

    /**
     * The function which called before an action
     *
     * @return void
     */
    protected function before()
    {

    }

    /**
     * The function which called after an action
     *
     * @return void
     */
    protected function after()
    {

    }
}