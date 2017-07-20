<?php
namespace Haruair\AzureFunctions;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class LocalRunner extends Runner
{
    /**
     * @var ServerRequestInterface
     */
    protected $serverRequest;

    public function setServerRequest(ServerRequestInterface $serverRequest)
    {
        $this->serverRequest = $serverRequest;
    }

    public function getContainer()
    {
        $container = parent::getContainer();

        $container->set(
            ServerRequestInterface::class,
            $this->serverRequest
        );

        return $container;
    }
}
