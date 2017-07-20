<?php
fwrite(STDOUT, print_r($_GET) . PHP_EOL);
fwrite(STDOUT, print_r($_POST) . PHP_EOL);

$data = json_decode(file_get_contents('php://input'));

$result = json_encode([
    'okay' => true,
    'data' => $data,
    'req' => file_get_contents(getenv('req')),
]);

file_put_contents(getenv('return'), json_encode($result));
