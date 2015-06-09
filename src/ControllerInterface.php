<?php
namespace SimpleMvc;

use SimpleMvc\Http\RequestInterface;

interface ControllerInterface
{
    /**
     * Dispatches a controller
     *
     * @param SimpleMvc\Http\RequestInterface $request
     * @return SimpleMvc\Http\ResponseInterface
     */
    public function dispatch(RequestInterface $request);
}
