<?php

namespace Haruair\HelloWorld;

class QueueTriggerPHP1
{
    public function run()
    {
        fwrite(STDOUT, 'Hello World from QueueTriggerPHP1.');
    }
}
