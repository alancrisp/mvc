<?php
namespace SimpleMvc;

interface ControllerProviderInterface
{
    public function addController($name, $controller);

    public function getController($name);

    public function hasController($name);
}
