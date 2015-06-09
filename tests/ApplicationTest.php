<?php
namespace SimpleMvcTest;

use SimpleMvc\Application;
use SimpleMvc\ControllerProvider;
use SimpleMvc\Http\Request;
use SimpleMvc\Http\Response;
use SimpleMvc\Router\Route\Literal;
use SimpleMvc\Router\Router;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    private $application;
    private $router;
    private $route;

    public function setup()
    {
        $this->router = $this->getMock('SimpleMvc\Router\RouterInterface');
        $this->route = $this->getMock('SimpleMvc\Router\Route\RouteInterface');
        $this->controllers = $this->createControllerProvider();
        $this->application = new Application($this->router, $this->controllers);
    }

    private function createControllerProvider()
    {
        $controllers = new ControllerProvider();
        $controllers->addController('hello', function () {
            return new Response(200, 'Hello!');
        });
        $controllers->addController('no-response', function () {});
        $controllers->addController('not-callable', 'not-callable');
        return $controllers;
    }

    public function testThrowsExceptionOnNoRouteMatch()
    {
        $this->router->method('match')->willReturn(false);
        $request = new Request('/blog');
        $this->setExpectedException('Exception', 'Unable to match route');
        $this->application->run($request);
    }

    public function testThrowsExceptionOnUnknownController()
    {
        $this->givenRouterMatchesRoute();
        $this->givenRouteProvidesControllerName('invalidController');
        $request = new Request('/');
        $this->setExpectedException('Exception', 'Route matched to unknown controller \'invalidController\'');
        $this->application->run($request);
    }

    public function testThrowsExceptionWhenControllerDoesNotProvideResponse()
    {
        $this->givenRouterMatchesRoute();
        $this->givenRouteProvidesControllerName('no-response');
        $this->setExpectedException('Exception', 'Controller \'no-response\' did not provide a response');
        $request = new Request('/');
        $this->application->run($request);
    }

    public function testReturnsResponse()
    {
        $this->givenRouterMatchesRoute();
        $this->givenRouteProvidesControllerName('hello');
        $request = new Request('/hello');
        $response = $this->application->run($request);
        $this->assertInstanceOf('SimpleMvc\Http\ResponseInterface', $response);
    }

    private function givenRouterMatchesRoute()
    {
        $this->router->method('match')->willReturn($this->route);
    }

    private function givenRouteProvidesControllerName($name)
    {
        $this->route->method('getControllerName')->willReturn($name);
    }
}
