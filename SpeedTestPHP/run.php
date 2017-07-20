<?php
fwrite(STDOUT, print_r($_GET) . PHP_EOL);
fwrite(STDOUT, print_r($_POST) . PHP_EOL);

$data = json_decode(file_get_contents('php://input'));

$result = json_encode([
    'REQ_ORIGINAL_URL' => getenv('REQ_ORIGINAL_URL'),
    'REQ_METHOD' => getenv('REQ_METHOD'),
    'REQ_QUERY' => getenv('REQ_QUERY'),
    'REQ_QUERY_QA' => getenv('REQ_QUERY_QA'),
    'REQ_HEADERS_HA' => getenv('REQ_HEADERS_HA'),
    'REQ_PARAMS_PA' => getenv('REQ_PARAMS_PA'),
    'okay' => true,
    'data' => $data,
    'req' => file_get_contents(getenv('req')),
]);

file_put_contents(getenv('return'), json_encode($result));
