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

        if (class_exists('Haruair\AzureFunctions\Runner')) {
            fwrite(STDOUT, '2 exists' . PHP_EOL);
        }

        if (class_exists(FunctionApp::class)) {
            fwrite(STDOUT, '1 exists' . PHP_EOL);
        }

        if (class_exists(\Haruair\AzureFunctions\Runner::class)) {
            fwrite(STDOUT, '5 exists' . PHP_EOL);
        }

        if (class_exists(Runner::class)) {
            fwrite(STDOUT, '4 exists' . PHP_EOL);
        }

        try {
            $runner = new Runner($this->basePath);
        } catch (\Exception $e) {
            fwrite(STDOUT, 'Exception aaa' . PHP_EOL);
        }
        
    }
}
