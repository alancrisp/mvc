<?php
namespace SimpleMvc;

use SimpleMvc\Http\RequestInterface;
use SimpleMvc\Router\RouterInterface;

class Application
{
    const EXCEPTION_NO_ROUTE_MATCH = 5001;
    const EXCEPTION_UNKNOWN_CONTROLLER = 5002;

    private $router;
    private $controllers;

    public function __construct(RouterInterface $router, array $controllers)
    {
        $this->router = $router;
        $this->controllers = $controllers;
    }

    public function dispatch(RequestInterface $request)
    {
        $matchedRoute = $this->router->match($request);
        if (!$matchedRoute) {
            throw new \Exception('Unable to match route', self::EXCEPTION_NO_ROUTE_MATCH);
        }

        $controllerName = $matchedRoute->getControllerName();
        if (!isset($this->controllers[$controllerName])) {
            throw new \Exception(sprintf(
                'Route matched to unknown controller \'%s\'',
                $controllerName
            ), self::EXCEPTION_UNKNOWN_CONTROLLER);
        }

        // @todo execute controller and return response
    }
}
