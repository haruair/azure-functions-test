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
        $i = 0;
        \fwrite(STDOUT, "PICK".$i++.PHP_EOL);

        $method = isset($_SERVER['REQ_METHOD']) ? $_SERVER['REQ_METHOD'] : 'GET';

        \fwrite(STDOUT, "PICK".$i++.PHP_EOL);
        $headers = self::getHeadersFromAzureFunctionsGlobals();

        \fwrite(STDOUT, "PICK".$i++.PHP_EOL);
        $uri = self::getUriFromGlobals();

        \fwrite(STDOUT, "PICK".$i++.PHP_EOL);
        $body = new LazyOpenStream(getenv('req'), 'r+');

        \fwrite(STDOUT, "PICK".$i++.PHP_EOL);
        $queryParams = self::getQueryParamsFromAzureFunctionsGlobals();

        \fwrite(STDOUT, "PICK".$i++.PHP_EOL);
        $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? str_replace('HTTP/', '', $_SERVER['SERVER_PROTOCOL']) : '1.1';

        \fwrite(STDOUT, "PICK".$i++.PHP_EOL);
        $serverRequest = new ServerRequest($method, $uri, $headers, $body, $protocol, $_SERVER);

        \fwrite(STDOUT, "PICK".$i++.PHP_EOL);
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
