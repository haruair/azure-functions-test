<?php

namespace Haruair\HelloWorld;

use Psr\Http\Message\RequestInterface;

class HelloPHP2
{
    public function run(RequestInterface $request)
    {
        ob_start();
        echo 'something';
        fwrite(STDOUT, 'Hello World from HelloPHP2.');
        fwrite(STDOUT, $request->getMethod());
        $d = ob_get_clean();
        fwrite(STDOUT, $d);
    }
}
