<?php
namespace SimpleMvc\Http;

interface ResponseInterface
{
    public function getStatusCode();

    public function getContent();
}
