<?php

namespace Haruair\AzureFunctions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ServerRequestInterface;

class Request implements ServerRequestInterface
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
    public function getServerParams()
    {

    }
    public function getCookieParams()
    {

    }
    public function withCookieParams(array $cookies)
    {

    }
    public function getQueryParams()
    {

    }
    public function withQueryParams(array $query)
    {

    }
    public function getUploadedFiles()
    {

    }
    public function withUploadedFiles(array $uploadedFiles)
    {

    }
    public function getParsedBody()
    {

    }
    public function withParsedBody($data)
    {

    }
    public function getAttributes()
    {

    }
    public function getAttribute($name, $default = null)
    {

    }
    public function withAttribute($name, $value)
    {

    }
    public function withoutAttribute($name)
    {

    }
}
