<?php
namespace SimpleMvcTest\Router;

use SimpleMvc\Http\Request;
use SimpleMvc\Router\Route\Literal;
use SimpleMvc\Router\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    private $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function testImplementsRouter()
    {
        $this->assertInstanceOf('SimpleMvc\Router\RouterInterface', $this->router);
    }

    /**
     * @dataProvider provideInvalidRouteName
     */
    public function testThrowsExceptionWhenAddingRouteWithInvalidName($name)
    {
        $route = new Literal('/', 'home');
        $this->setExpectedException('InvalidArgumentException', 'Invalid route name');
        $this->router->addRoute($name, $route);
    }

    public function testMatchesRequest()
    {
        $route   = new Literal('/', 'home');
        $request = new Request('/');
        $this->router->addRoute('home', $route);
        $this->assertSame($route, $this->router->match($request));
    }

    /**
     * @dataProvider provideInvalidRouteName
     */
    public function testThrowsExceptionWhenAssemblingRouteWithInvalidName($name)
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid route name');
        $this->router->assemble($name);
    }

    public function testThrowsExceptionWhenAssemblingUnknownRoute()
    {
        $this->setExpectedException('Exception', 'Unknown route with name \'blog\'');
        $this->router->assemble('blog');
    }

    public function testAssembles()
    {
        $route = new Literal('/', 'home');
        $this->router->addRoute('home', $route);
        $this->assertEquals('/', $this->router->assemble('home'));
    }

    public function provideInvalidRouteName()
    {
        return [
            [''],
            [new \stdClass()],
        ];
    }
}
