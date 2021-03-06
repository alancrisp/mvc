<?php
namespace SimpleMvcTest;

use SimpleMvc\ControllerProvider;

class ControllerProviderTest extends \PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp()
    {
        $this->provider = new ControllerProvider();
    }

    public function testImplementsControllerProvider()
    {
        $this->assertInstanceOf('SimpleMvc\ControllerProviderInterface', $this->provider);
    }

    /**
     * @dataProvider provideInvalidController
     */
    public function testThrowsExceptionWhenSettingInvalidController($controller)
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Controller is not callable or an instance of SimpleMvc\ControllerInterface'
        );
        $this->provider->addController('test', $controller);
    }

    public function provideInvalidController()
    {
        return [
            ['undefinedFunction'],
            [new \stdClass()],
        ];
    }

    public function testSetsController()
    {
        $controller = $this->getMock('SimpleMvc\ControllerInterface');
        $this->provider->addController('test', $controller);
        $this->assertTrue($this->provider->hasController('test'));
    }

    public function testThrowsExceptionWhenGettingUnsetController()
    {
        $this->setExpectedException('Exception', 'Controller \'not-set\' is not set');
        $this->provider->getController('not-set');
    }

    public function testGetsController()
    {
        $controller = $this->getMock('SimpleMvc\ControllerInterface');
        $this->provider->addController('test', $controller);
        $this->assertSame($controller, $this->provider->getController('test'));
    }
}
