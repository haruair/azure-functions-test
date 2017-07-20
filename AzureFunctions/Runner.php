<?php

namespace Haruair\AzureFunctions;

class Runner
{
    protected $basePath;

    public static function Run(string $basePath = null)
    {
        fwrite(STDOUT, 'call Run');
        if (is_null($basePath))
        {
            $basePath = $_SERVER['EXECUTION_CONTEXT_FUNCTIONDIRECTORY'];
        }
        fwrite(STDOUT, 'basePath is ' . $basePath);
        $runner = new Self($basePath);
    }

    protected function __construct(string $basePath)
    {
        $this->basePath = $basePath;
        fwrite(STDOUT, 'constructed');
        fwrite(STDOUT, $this->getEntryPoint());
    }

    public function getEntryPoint()
    {
        $config = json_decode(file_get_contents($this->basePath . DIRECTORY_SEPARATOR . 'function.json'));
        fwrite(STDOUT, 'get Entry Point');
        return $config->entryPoint;
    }
}
