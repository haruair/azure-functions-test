<?php
require_once(__DIR__.'/../bootstrap.php');
fwrite(STDOUT, __DIR__.PHP_EOL);
Haruair\AzureFunctions\Runner::Run(__DIR__);
