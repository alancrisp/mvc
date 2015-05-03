<?php
namespace SimpleMvc\Http;

class Response implements ResponseInterface
{
    private $statusCode;
    private $content;

    public function __construct($statusCode, $content = '')
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getContent()
    {
        return $this->content;
    }
}
