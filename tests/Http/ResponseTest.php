<?php
namespace SimpleMvcTest\Http;

use SimpleMvc\Http\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    private $response;

    public function setup()
    {
        $this->response = new Response(200, 'Hello');
    }

    public function testImplementsResponse()
    {
        $this->assertInstanceOf('SimpleMvc\Http\ResponseInterface', $this->response);
    }

    public function testProvidesStatusCode()
    {
        $this->assertEquals(200, $this->response->getStatusCode());
    }

    public function testProvidesContent()
    {
        $this->assertEquals('Hello', $this->response->getContent());
    }
}
