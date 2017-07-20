<?php
fwrite(STDOUT, print_r($_GET) . PHP_EOL);
fwrite(STDOUT, print_r($_POST) . PHP_EOL);

$data = json_decode(file_get_contents('php://input'));

echo json_encode([
    'okay' => true,
    'data' => $data,
]);
