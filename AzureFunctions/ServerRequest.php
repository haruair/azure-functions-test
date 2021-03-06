<?php

namespace Haruair\AzureFunctions;

use GuzzleHttp\Psr7\ServerRequest as BaseServerRequest;
use GuzzleHttp\Psr7\LazyOpenStream;

class ServerRequest extends BaseServerRequest
{
    /**
     * Return a ServerRequest populated with superglobals:
     * $_GET
     * $_POST
     * $_COOKIE
     * $_FILES
     * $_SERVER
     *
     * @return ServerRequestInterface
     */
    public static function fromAzureFunctionsGlobals()
    {
        $method = isset($_SERVER['REQ_METHOD']) ? $_SERVER['REQ_METHOD'] : 'GET';
        $headers = self::getHeadersFromAzureFunctionsGlobals();
        $uri = self::getUriFromGlobals();
        $body = file_get_contents(getenv('req'));
        $queryParams = self::getQueryParamsFromAzureFunctionsGlobals();
        $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? str_replace('HTTP/', '', $_SERVER['SERVER_PROTOCOL']) : '1.1';
        $serverRequest = new ServerRequest($method, $uri, $headers, $body, $protocol, $_SERVER);
        return $serverRequest
            ->withCookieParams($_COOKIE)
            ->withQueryParams($queryParams)
            ->withUploadedFiles(self::normalizeFiles($_FILES));
    }

    public static function getQueryParamsFromAzureFunctionsGlobals()
    {
        $query = getenv('REQ_QUERY');

        if (strlen($query) > 0)
        {
            return parse_str(substr($query, 1));
        }
        return [];
    }

    public static function getHeadersFromAzureFunctionsGlobals()
    {
        $prefix = 'REQ_HEADERS_';
        $headers = [];
        foreach ($_SERVER as $name => $value)
        {
            if (substr($name, 0, strlen($prefix)) == $prefix)
            {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, strlen($prefix))))))] = $value;
            }
        }
        return $headers;
    }
}
