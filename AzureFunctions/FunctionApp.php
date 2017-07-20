<?php

namespace Haruair\AzureFunctions;

class FunctionApp
{
    protected $runner;

    public function __construct($basePath = null)
    {
        if (is_null($basePath))
        {
            $basePath = @$_SERVER['EXECUTION_CONTEXT_FUNCTIONDIRECTORY'];
        }

        if (is_null($basePath) && php_sapi_name() == 'cli')
        {
            return new LocalServer(__DIR__  . '/..');
        }

        if (!file_exists($basePath))
        {
            throw new \Exception('File does not exist. ' . $basePath);
        }

        $this->runner = new WebJobRunner($basePath);
        $this->runner->execute();
    }
}
