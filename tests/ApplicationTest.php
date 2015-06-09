<?php
namespace SimpleMvcTest;

use SimpleMvc\Application;
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
        $this->application = new Application($this->router, [
            'hello' => function () { return new Response(200, 'Hello!'); },
            'no-response' => function () {},
            'not-callable' => 'not-callable',
        ]);
    }

    public function testThrowsExceptionOnNoRouteMatch()
    {
        $this->router->method('match')->willReturn(false);
        $request = new Request('/blog');
        $this->setExpectedException('Exception', 'Unable to match route');
        $this->application->dispatch($request);
    }

    public function testThrowsExceptionOnUnknownController()
    {
        $this->givenRouterMatchesRoute();
        $this->givenRouteProvidesControllerName('invalidController');
        $request = new Request('/');
        $this->setExpectedException('Exception', 'Route matched to unknown controller \'invalidController\'');
        $this->application->dispatch($request);
    }

    public function testThrowsExceptionWhenControllerIsNotCallable()
    {
        $this->givenRouterMatchesRoute();
        $this->givenRouteProvidesControllerName('not-callable');
        $this->setExpectedException('Exception', 'Controller \'not-callable\' is not callable');
        $request = new Request('/');
        $this->application->dispatch($request);
    }

    public function testThrowsExceptionWhenControllerDoesNotProvideResponse()
    {
        $this->givenRouterMatchesRoute();
        $this->givenRouteProvidesControllerName('no-response');
        $this->setExpectedException('Exception', 'Controller \'no-response\' did not provide a response');
        $request = new Request('/');
        $this->application->dispatch($request);
    }

    public function testReturnsResponse()
    {
        $this->givenRouterMatchesRoute();
        $this->givenRouteProvidesControllerName('hello');
        $request = new Request('/hello');
        $response = $this->application->dispatch($request);
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
