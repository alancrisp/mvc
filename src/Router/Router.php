<?php
namespace SimpleMvc\Router;

use SimpleMvc\Http\RequestInterface;
use SimpleMvc\Router\Route\RouteInterface;

class Router implements RouterInterface
{
    private $routes = [];

    public function addRoute($name, RouteInterface $route)
    {
        $this->routes[$name] = $route;
    }

    public function match(RequestInterface $request)
    {
        foreach ($this->routes as $route) {
            if ($route->match($request)) {
                return $route;
            }
        }
    }

    public function assemble($name, array $params = [])
    {
        if (!isset($this->routes[$name])) {
            throw new \Exception(sprintf(
                'Unknown route with name \'%s\'',
                $name
            ));
        }

        return $this->routes[$name]->assemble($params);
    }
}
