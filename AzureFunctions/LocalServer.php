<?php

namespace Haruair\AzureFunctions;

use Psr;
use React;

class LocalServer
{
    public function __construct($basePath)
    {
        $loop = React\EventLoop\Factory::create();

        $basePath = realpath($basePath);
        $functionConfigs = glob($basePath . '/*/function.json');

        $routes = [];

        foreach($functionConfigs as $path) {
            $config = json_encode(file_get_contents($path));
            $functionPath = dirname(realpath($path));

            $bindings = isset($config->bindings) ? $config->bindings : [];
            $_routes = array_filter(array_map(function($binding) {
                return isset($binding->route) ? $binding->route : null;
            }, array_filter($bindings, function($binding) {
                return isset($binding->direction) && $binding->direction === 'in' && isset($binding->type) && $binding->type === 'httpTrigger';
            })));
            $route = array_shift($_routes);
            if (empty($route)) {
                $functionName = explode(DIRECTORY_SEPARATOR, $functionPath);
                $route = array_pop($functionName);
            }

            $routes['/'.$route] = $functionPath;
            $printFuncPath = str_replace($basePath, '.', $functionPath);
            echo "Loaded /{$route} ({$printFuncPath})" . PHP_EOL;
        }

        $server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) use ($routes) {
            $tmpHandle = tmpfile();
            $metaData = stream_get_meta_data($tmpHandle);

            putenv('req=php://input');
            putenv('$return='.$metaData['uri']);

            $route = $request->getUri()->getPath();
            
            if (isset($routes[$route])) {
                $runner = new LocalRunner($routes[$route]);
                $runner->setServerRequest($request);
                $runner->execute();
            } else {
                return new React\Http\Response(
                    404,
                    array('Content-Type' => 'text/plain'),
                    '404 Not Found'
                );
            }

            $response = file_get_contents(getenv('$return'));
            fclose($tmpHandle);

            return new React\Http\Response(
                200,
                array('Content-Type' => 'text/plain'),
                $response
            );
        });

        $socket = new React\Socket\Server(8080, $loop);
        $server->listen($socket);

        echo "Server running at http://127.0.0.1:8080\n";

        $loop->run();
    }
}
