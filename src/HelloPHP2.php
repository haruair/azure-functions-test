<?php

namespace Haruair\HelloWorld;

use Psr\Http\Message\RequestInterface;

class HelloPHP2
{
    public function run(RequestInterface $request)
    {
        fwrite(STDOUT, 'Hello World from HelloPHP2.');
        fwrite(STDOUT, $request->getMethod());
    }
}
