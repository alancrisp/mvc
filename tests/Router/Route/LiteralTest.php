<?php
namespace SimpleMvcTest\Router\Route;

use SimpleMvc\Http\Request;
use SimpleMvc\Router\Route\Literal;

class LiteralTest extends \PHPUnit_Framework_TestCase
{
    private $route;

    public function setUp()
    {
        $this->route = new Literal('/contact', 'contact');
    }

    public function testImplementsRoute()
    {
        $this->assertInstanceOf('SimpleMvc\Router\Route\RouteInterface', $this->route);
    }

    /**
     * @dataProvider provideInvalidNonEmptyString
     */
    public function testThrowsExceptionOnInvalidRoute($route)
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid route');
        $route = new Literal($route, 'controller');
    }

    /**
     * @dataProvider provideInvalidNonEmptyString
     */
    public function testThrowsExceptionOnInvalidControllerName($controllerName)
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid controller name');
        $route = new Literal('/', $controllerName);
    }

    public function testMatchesRequest()
    {
        $request = new Request('/contact');
        $this->assertTrue($this->route->match($request));
    }

    public function testAssembles()
    {
        $this->assertEquals('/contact', $this->route->assemble());
    }

    public function testProvidesControllerName()
    {
        $this->assertEquals('contact', $this->route->getControllerName());
    }

    public function provideInvalidNonEmptyString()
    {
        return [
            [''],
            [new \stdClass()],
        ];
    }
}
