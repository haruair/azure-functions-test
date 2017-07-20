<?php

namespace Haruair\HelloWorld;

use Psr\Http\Message\ServerRequestInterface;

class HelloPHP2
{
    public function run(ServerRequestInterface $request)
    {
        fwrite(STDOUT, 'Hit the server');
        $data = json_decode($request->getBody());

        return [
            'okay' => true,
            'data' => $data,
        ];
    }
}
