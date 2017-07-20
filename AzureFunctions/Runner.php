<?php

namespace Haruair\AzureFunctions;

class Runner
{
    protected $basePath;

    public static function Run(string $basePath = null)
    {
        fwrite(STDOUT, 'call Run'.PHP_EOL);
        if (is_null($basePath))
        {
            $basePath = @$_SERVER['EXECUTION_CONTEXT_FUNCTIONDIRECTORY'];
        }

        if (is_null($basePath))
        {
            $basePath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'HelloPHP2';
        }
        fwrite(STDOUT, 'basePath is ' . $basePath.PHP_EOL);
        $runner = new Self($basePath);
    }

    protected function __construct(string $basePath)
    {
        $this->basePath = $basePath;
        fwrite(STDOUT, 'constructed'.PHP_EOL);
        fwrite(STDOUT, $this->getEntryPoint().PHP_EOL);
    }

    public function getEntryPoint()
    {
        $config = json_decode(file_get_contents($this->basePath . DIRECTORY_SEPARATOR . 'function.json'));
        fwrite(STDOUT, 'get Entry Point'.PHP_EOL);
        return $config->entryPoint;
    }
}
