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

        return new Runner($basePath);
    }
}
