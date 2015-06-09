<?php
namespace SimpleMvc;

class ControllerProvider implements ControllerProviderInterface
{
    private $controllers = [];

    public function addController($name, $controller)
    {
        if (!$controller instanceof ControllerInterface &&
            !is_callable($controller)
        ) {
            throw new \InvalidArgumentException(
                'Controller is not callable or an instance of SimpleMvc\ControllerInterface'
            );
        }

        $this->controllers[$name] = $controller;
    }

    public function getController($name)
    {
        if (!$this->hasController($name)) {
            throw new \Exception(sprintf(
                'Controller \'%s\' is not set',
                $name
            ));
        }

        return $this->controllers[$name];
    }

    public function hasController($name)
    {
        return isset($this->controllers[$name]);
    }
}
