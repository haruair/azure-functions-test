<?php

namespace Haruair\AzureFunctions;

class FunctionApp
{
    protected $runner;

    public function __construct($basePath = null)
    {
        if (php_sapi_name() == 'cli')
        {
            $this->runner = new LocalRunner(__DIR__  . '/..');
            return $this;
        }

        if (is_null($basePath))
        {
            $basePath = @$_SERVER['EXECUTION_CONTEXT_FUNCTIONDIRECTORY'];
        }

        if (!file_exists($basePath))
        {
            throw new \Exception('File does not exist. ' . $basePath);
        }

        $this->runner = new Runner($basePath);
    }
}
