<?php

class Router
{
    protected $routes = [];
    protected $params = [];

    /**
     * Add a new route, by converting route string to regexp for flexible
     * routes. That will help to determine which part of the route is a
     * controller and which is an action. For example:
     * {controller}/{action}            -> /^(?<controller>[a-z-]+)\/(?<action>[a-z-]+)/
     * admin/{controller}/blog/{action} -> /^admin\/(?<controller>[a-z-]+)\/blog\/(?<action>[a-z-]+)/
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function add($route, $params = [])
    {
        // escape forward slashes in the route string
        $route = preg_replace('/\//', '\/', $route);
        // convert variables into regexp
        $route = preg_replace('/\{([a-z-]+)\}/', '(?<\1>[a-z-]+)', $route);
        // convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?<\1>\2)', $route);

        $route = '/^' . $route . '$/';

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
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Call the action of the controller which were taken from query string.
     *
     * @return void
     */
    public function dispatch($url)
    {
        if ($this->match($url)) {
            $controller_name = $this->params['controller'];
            $controller_name = $this->convertToStudlyCaps($controller_name);

            if (class_exists($controller_name)) {
                $controller = new $controller_name();
                
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller, $action])) {
                    $controller->$action();
                } else {
                    echo "Method $action not found in $controller_name.";
                }
            } else {
                echo "Class $controller_name not found.";
            }
        } else {
            echo "404 NOT FOUND.";
        }
    }

    /**
     * Convert strings with hyphens to StudlyCaps strings.
     * e.g. forum-directory -> ForumDirectory
     *
     * @param string $string
     * @return string
     */
    public function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert strings with hyphens to camelCase strings.
     * e.g. action-name -> actionName
     *
     * @param string $string
     * @return string
     */
    public function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
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