<?php
namespace SimpleMvcTest\Http;

use SimpleMvc\Http\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    private $request;

    public function setUp()
    {
        $this->request = new Request('/');
    }

    public function testImplementsRequest()
    {
        $this->assertInstanceOf('SimpleMvc\Http\RequestInterface', $this->request);
    }

    public function testProvidesPath()
    {
        $this->assertEquals('/', $this->request->getPath());
    }
}
