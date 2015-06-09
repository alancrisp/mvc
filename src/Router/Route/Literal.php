<?php
namespace SimpleMvc\Router\Route;

use SimpleMvc\Http\RequestInterface;

class Literal implements RouteInterface
{
    private $route;
    private $controllerName;

    public function __construct($route, $controllerName)
    {
        if (!is_string($route) || '' == $route) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid route \'%s\'',
                var_export($route, true)
            ));
        }
        if (!is_string($controllerName) || '' == $controllerName) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid controller name \'%s\'',
                var_export($controllerName, true)
            ));
        }

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
