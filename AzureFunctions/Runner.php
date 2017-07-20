<?php

namespace Haruair\AzureFunctions;

use DI\ContainerBuilder;
use Exception;

class Runner
{
    protected $basePath;
    protected $config;
    protected $container = null;

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
        ob_start();
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
        $result = ob_get_clean();
        file_put_contents(getenv('return'), $result);
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
        $config = $this->getConfig();
        return isset($config->entryPoint) ? $config->entryPoint : null;
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
