<?php

namespace TestFramework\Core;

class Router
{
    protected $routes = [];
    protected $params = [];

    /**
     * Get the list of routes
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
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
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller_name = $this->params['controller'];
            $controller_name = $this->convertToStudlyCaps($controller_name);
            $controller_name = $this->getNamespace() . $controller_name;

            if (class_exists($controller_name)) {
                $controller = new $controller_name($this->params);
                
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller, $action])) {
                    $controller->$action();
                } else {
                    throw new \Exception("Method $action not found in $controller_name.");
                }
            } else {
                throw new \Exception("Class $controller_name not found.");
            }
        } else {
            throw new \Exception("No route matched.", 404);
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
     * Remove query string variables from an url for matching
     * an url to routes. Due to sending all requests to 
     * 'host.ru/index.php?' the question mark before the query string
     * transforms to an ampersand, so we trim a part of the url after
     * the first ampersand symbol instead of after the question mark. 
     * e.g. 
     * url - http://host.ru/posts?first=smth&second=good
     * query string - posts&first=smth&second=good
     * url for matching routes - posts
     * 
     * @param string $url
     * @return string $url
     */
    public function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    /**
     * Get the right namespace for a controller class. The namespace
     * defined in the route parameters is added if present.
     *
     * @return string
     */
    protected function getNamespace()
    {
        $namespace = 'TestFramework\App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}