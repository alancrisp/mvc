<?php
namespace SimpleMvc\Router\Route;

use SimpleMvc\Http\RequestInterface;

interface RouteInterface
{
    public function match(RequestInterface $request);

    public function assemble(array $params = []);
}
