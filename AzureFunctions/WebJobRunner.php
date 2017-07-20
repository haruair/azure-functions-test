<?php
namespace Haruair\AzureFunctions;

use Psr\Http\Message\ServerRequestInterface;

class WebJobRunner extends Runner
{
    public function getContainer()
    {
        $container = parent::getContainer();

        $container->set(
            ServerRequestInterface::class,
            \DI\factory([
                ServerRequest::class,
                'fromAzureFunctionsGlobals'
            ])
        );

        return $container;
    }
}
