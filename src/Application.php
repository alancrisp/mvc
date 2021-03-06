<?php
namespace SimpleMvc;

use SimpleMvc\Http\RequestInterface;
use SimpleMvc\Http\ResponseInterface;
use SimpleMvc\Router\RouterInterface;

class Application
{
    private $router;
    private $controllers;

    public function __construct(RouterInterface $router, ControllerProviderInterface $controllers)
    {
        $this->router = $router;
        $this->controllers = $controllers;
    }

    public function run(RequestInterface $request)
    {
        $matchedRoute = $this->router->match($request);
        if (!$matchedRoute) {
            throw new \Exception('Unable to match route');
        }

        $controllerName = $matchedRoute->getControllerName();
        if (!$this->controllers->hasController($controllerName)) {
            throw new \Exception(sprintf(
                'Route matched to unknown controller \'%s\'',
                $controllerName
            ));
        }

        $controller = $this->controllers->getController($controllerName);
        $response = call_user_func($controller, $request);
        if (!$response instanceof ResponseInterface) {
            throw new \Exception(sprintf(
                'Controller \'%s\' did not provide a response',
                $controllerName
            ));
        }

        return $response;
    }
}
