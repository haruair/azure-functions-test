<?php

namespace Haruair\HelloWorld;

class HelloPHP2
{
    public function run(Request $request)
    {
        fwrite(STDOUT, 'Hello World from HelloPHP2.');
        fwrite(STDOUT, $request->getMethod());
    }
}
