<?php

namespace Haruair\HelloWorld;

use Psr\Http\Message\RequestInterface;

class HelloPHP2
{
    public function run(RequestInterface $request)
    {
        fwrite(STDOUT, 'Hit the server');
        $data = json_decode($request->getBody());

        return [
            'okay' => true,
            'data' => $data,
        ];
    }
}
