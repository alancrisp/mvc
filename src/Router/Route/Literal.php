<?php
namespace SimpleMvc\Router\Route;

use SimpleMvc\Http\RequestInterface;

class Literal implements RouteInterface
{
    private $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function match(RequestInterface $request)
    {
        return $this->route == $request->getPath();
    }

    public function assemble(array $params = [])
    {
        return $this->route;
    }
}
