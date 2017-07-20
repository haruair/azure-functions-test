<?php

namespace Haruair\AzureFunctions;

class Runner
{
    protected $basePath;

    public static function Run(string $basePath)
    {
        $runner = new Self($basePath);
    }

    protected function __construct(string $basePath)
    {
        $this->basePath = $basePath;
        fwrite(STDOUT, $this->getEntryPoint());
    }

    public function getEntryPoint()
    {
        $config = json_decode(file_get_contents($this->basePath.'/function.json'));
        return $config->entryPoint;
    }
}
