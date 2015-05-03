<?php
namespace SimpleMvc;

use SimpleMvc\Http\RequestInterface;
use SimpleMvc\Http\ResponseInterface;
use SimpleMvc\Router\RouterInterface;

class Application
{
    const EXCEPTION_NO_ROUTE_MATCH = 5001;
    const EXCEPTION_UNKNOWN_CONTROLLER = 5002;
    const EXCEPTION_NO_RESPONSE = 5003;

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

        $controller = $this->controllers[$controllerName];
        $response = call_user_func($controller, $request);
        if (!$response instanceof ResponseInterface) {
            throw new \Exception(sprintf(
                'Controller \'%s\' did not provide a response',
                $controllerName
            ), self::EXCEPTION_NO_RESPONSE);
        }

        return $response;
    }
}
