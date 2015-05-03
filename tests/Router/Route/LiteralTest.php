<?php
namespace SimpleMvcTest\Router\Route;

use SimpleMvc\Http\Request;
use SimpleMvc\Router\Route\Literal;

class LiteralTest extends \PHPUnit_Framework_TestCase
{
    private $route;

    public function setup()
    {
        $this->route = new Literal('/contact');
    }

    public function testImplementsRoute()
    {
        $this->assertInstanceOf('SimpleMvc\Router\Route\RouteInterface', $this->route);
    }

    public function testMatchesValidRequest()
    {
        $request = new Request('/contact');
        $this->assertTrue($this->route->match($request));
    }

    public function testDoesNotMatchInvalidRequest()
    {
        $request = new Request('/');
        $this->assertFalse($this->route->match($request));
    }

    public function testAssembles()
    {
        $this->assertEquals('/contact', $this->route->assemble());
    }
}
