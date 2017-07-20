<?php

namespace Haruair\AzureFunctions;

use DI\ContainerBuilder;
use Exception;

class Runner
{
    protected $basePath;
    protected $container = null;

    public function __construct($basePath = null)
    {
        fwrite(STDOUT, 'hit herer1');
        $this->basePath = $basePath;
        list($className, $methodName) = explode('::', $this->getEntryPoint());

        fwrite(STDOUT, $className);
        fwrite(STDOUT, $methodName);

        fwrite(STDOUT, 'hit here');

        $container = $this->getContainer();
        $instance = $container->get($className);

        try
        {
            $container->call([$instance, $methodName]);
        }
        catch(Exception $e)
        {
            // log
            fwrite(STDOUT, print_r($e, true));
        }
    }

    public function getContainer()
    {
        if (!is_null($this->container)) {
            return $this->container;
        }

        $builder = new ContainerBuilder();
        $container = $builder->build();

        $this->container = $container;
        return $container;
    }

    public function getEntryPoint()
    {
        $config = json_decode(file_get_contents($this->basePath . DIRECTORY_SEPARATOR . 'function.json'));
        return $config->entryPoint;
    }
}
