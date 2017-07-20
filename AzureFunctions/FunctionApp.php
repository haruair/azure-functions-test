<?php

namespace Haruair\AzureFunctions;

class FunctionApp
{
    protected $basePath;

    public function __construct($basePath = null)
    {
        if (is_null($basePath))
        {
            $basePath = @$_SERVER['EXECUTION_CONTEXT_FUNCTIONDIRECTORY'];
        }
        $this->basePath = $basePath;
    }

    public function execute()
    {
        try {
            $runner = new Runner($this->basePath);
        } catch (\Exception $e) {
            fwrite(STDOUT, 'Exception aaa' . PHP_EOL);
        }
        
    }
}
