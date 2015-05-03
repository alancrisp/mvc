<?php
namespace SimpleMvc\Router\Route;

use SimpleMvc\Http\RequestInterface;

class Literal implements RouteInterface
{
    private $route;
    private $controllerName;

    public function __construct($route, $controllerName)
    {
        $this->route = $route;
        $this->controllerName = $controllerName;
    }

    public function match(RequestInterface $request)
    {
        return $this->route == $request->getPath();
    }

    public function assemble(array $params = [])
    {
        return $this->route;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }
}
