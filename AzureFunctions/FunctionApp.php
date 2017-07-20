<?php

namespace Haruair\AzureFunctions;

class FunctionApp
{
    protected $basePath;
    public function __construct(string $basePath = null)
    {
        if (is_null($basePath))
        {
            $basePath = @$_SERVER['EXECUTION_CONTEXT_FUNCTIONDIRECTORY'];
        }
        $this->basePath = $basePath;
    }

    public function execute()
    {
        fwrite(STDOUT, 'lets execute' . PHP_EOL);
        $runner = new Runner($this->basePath);
    }
}
