<?php

namespace Haruair\AzureFunctions;

class FunctionApp
{
    public function __construct(string $basePath = null)
    {
        fwrite(STDOUT, 'hit here1');
        if (is_null($basePath))
        {
        fwrite(STDOUT, 'hit here2');
            $basePath = @$_SERVER['EXECUTION_CONTEXT_FUNCTIONDIRECTORY'];
        }
        fwrite(STDOUT, 'hit here3');
        $runner = new Runner($basePath);
    }
}
