<?php

namespace Haruair\AzureFunctions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request implements RequestInterface
{
    public function getRequestTarget()
    {

    }

    public function withRequestTarget($requestTarget)
    {

    }

    public function withMethod($method)
    {

    }

    public function getUri()
    {
        return getenv('REQ_ORIGINAL_URL');
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {

    }

    public function getMethod()
    {
        return getenv('req_method');
    }

    public function getProtocolVersion()
    {

    }

    public function withProtocolVersion($version)
    {

    }

    public function getHeaders()
    {

    }

    public function hasHeader($name)
    {
        return $this->getHeader($name) === false;
    }

    public function getHeader($name)
    {
        return getenv('REQ_HEADERS_' . $name);
    }

    public function getHeaderLine($name)
    {
        return $name . ': ' . $this->getHeader($name);
    }

    public function withHeader($name, $value)
    {

    }

    public function withAddedHeader($name, $value)
    {

    }

    public function withoutHeader($name)
    {

    }

    public function getBody()
    {
        return file_get_contents(getenv('req'));
    }

    public function withBody(StreamInterface $body)
    {

    }
}
