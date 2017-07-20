<?php

namespace Haruair\AzureFunctions;

use DI\ContainerBuilder;
use Psr\Http\Message\ServerRequestInterface;

use Exception;

class Runner
{
    protected $basePath;
    protected $config;

    public function __construct($basePath = null)
    {
        $this->basePath = $basePath;

        if (is_null($this->getEntryPoint())) {
            $this->executeFile();
        } else {
            $this->executeByEntryPoint();
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
        // ob_start();
        fwrite(STDOUT, 'Before create instance');
        $instance = $container->get($className);
        fwrite(STDOUT, 'After create instance');

        try
        {
            fwrite(STDOUT, 'Before call');
            $returnValue = $container->call([$instance, $methodName]);
            fwrite(STDOUT, 'After call');
        }
        catch(Exception $e)
        {
            // log
            fwrite(STDOUT, print_r($e, true));
        }
        $output = ob_get_clean();

        if (!empty($returnValue)) {
            if (!is_string($returnValue)) {
                $returnValue = \json_encode($returnValue);
            }

            $outs = $this->getOutNames();
            foreach($outs as $out) {
                file_put_contents(getenv($out), $returnValue);
            }
        }
    }

    public function getContainer()
    {
        $builder = new ContainerBuilder();
        fwrite(STDOUT, 'Before container created');
        $container = $builder->build();

        $container->set(
            ServerRequestInterface::class,
            \DI\factory([
                ServerRequest::class,
                'fromAzureFunctionsGlobals'
            ])
        );

        fwrite(STDOUT, 'After container created');
        $this->container = $container;
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
