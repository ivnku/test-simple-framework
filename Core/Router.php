<?php

class Router
{
    protected $routes = [];
    protected $params = [];

    /**
     * Add a new route
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function add($route, $params)
    {
        $this->routes[$route] = $params;
    }

    /**
     * Get the list of routes
     *
     * @return array of routes
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Check if the url match any routes
     *
     * @param string $url
     * @return boolean
     */
    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if ($route == $url) {
                $this->params = $params;
                return true;
            }  
        }
        return false;
    }

    /**
     * Get the currently matched params
     *
     * @return array
     */
    public function getParams() 
    {
        return $this->params;
    }
}