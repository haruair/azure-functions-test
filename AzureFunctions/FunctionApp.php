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

        $this->runner = new Runner($basePath);
    }
}
