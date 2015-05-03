<?php
namespace SimpleMvcTest;

use SimpleMvc\Application;
use SimpleMvc\Http\Request;
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
        $this->application = new Application($this->router, []);
    }

    public function testThrowsExceptionOnNoRouteMatch()
    {
        $this->router->method('match')->willReturn(false);
        $request = new Request('/blog');
        $this->setExpectedException('Exception', '', Application::EXCEPTION_NO_ROUTE_MATCH);
        $this->application->dispatch($request);
    }

    public function testThrowsExceptionOnUnknownController()
    {
        $this->router->method('match')->willReturn($this->route);
        $this->route->method('getControllerName')->willReturn('invalidController');
        $request = new Request('/');
        $this->setExpectedException('Exception', '', Application::EXCEPTION_UNKNOWN_CONTROLLER);
        $this->application->dispatch($request);
    }
}
