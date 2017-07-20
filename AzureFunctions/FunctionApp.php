<?php

namespace Haruair\AzureFunctions;

class FunctionApp
{
    public function __construct(string $basePath = null)
    {
        if (is_null($basePath))
        {
            $basePath = @$_SERVER['EXECUTION_CONTEXT_FUNCTIONDIRECTORY'];
        }

        if (is_null($basePath))
        {
            $basePath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'HelloPHP2';
        }

        return new Runner($basePath);
    }
}
