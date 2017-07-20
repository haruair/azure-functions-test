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
            global $argv;
            if (isset($argv[1])) {
                $basePath = $argv[1];
            }
        }

        $this->runner = new Runner($basePath);
    }
}
