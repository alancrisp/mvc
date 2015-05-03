<?php
namespace SimpleMvc\Router;

use SimpleMvc\Http\RequestInterface;
use SimpleMvc\Router\Route\RouteInterface;

interface RouterInterface
{
    const EXCEPTION_UNKNOWN_ROUTE = 1001;

    public function addRoute($name, RouteInterface $route);

    public function match(RequestInterface $request);

    public function assemble($name, array $params = []);
}
