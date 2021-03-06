<?php

namespace Haruair\AzureFunctions;

use DI\ContainerBuilder;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;

use Exception;

class Runner
{
    protected $basePath;
    protected $config;

    public function __construct($basePath = null)
    {
        $this->basePath = $basePath;
    }

    public function execute()
    {
        if (is_null($this->getEntryPoint())) {
            return $this->executeFile();
        } else {
            return $this->executeByEntryPoint();
        }
    }

    public function executeFile()
    {
        $config = $this->getConfig();
        $filePath = 'run.php';

        if (isset($config->scriptFile)) {
            $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $config->scriptFile);
        }

        require_once($this->basePath . DIRECTORY_SEPARATOR . $filePath);
    }

    public function executeByEntryPoint()
    {
        list($className, $methodName) = explode('::', $this->getEntryPoint());

        $container = $this->getContainer();

        ob_start();
        $instance = $container->get($className);

        try
        {
            $response = $container->call([$instance, $methodName]);
        }
        catch(Exception $e)
        {
            // log
            fwrite(STDOUT, print_r($e, true));
        }

        $output = ob_get_clean();
        if ($response instanceof ResponseInterface === false) {
            $responseBody = is_string($response) ? $response : \json_encode($response);
            $response = new Response(200, [], $responseBody);
        }

        if (!is_null($response)) {
            $outs = $this->getOutNames();
            foreach($outs as $out) {
                file_put_contents(getenv($out), $response->getBody());
            }
        }
        return $response;
    }

    public function getContainer()
    {
        $builder = new ContainerBuilder();
        $container = $builder->build();

        return $container;
    }

    public function getEntryPoint()
    {
        $config = $this->getConfig();
        return isset($config->entryPoint) ? $config->entryPoint : null;
    }

    public function getOutNames()
    {
        $config = $this->getConfig();
        $bindings = isset($config->bindings) ? $config->bindings : [];
        $filtered = array_filter(array_map(function($binding) {
            return isset($binding->name) ? $binding->name : null;
        }, array_filter($bindings, function($binding) {
            return isset($binding->direction) && $binding->direction === 'out' && isset($binding->type) && $binding->type === 'http';
        })));
        return $filtered;
    }

    public function getConfig()
    {
        if (!is_null($this->config))
        {
            return $this->config;
        }

        $this->config = json_decode(file_get_contents($this->basePath . DIRECTORY_SEPARATOR . 'function.json'));
        return $this->config;
    }
}
