<?php
ob_start();
phpinfo(INFO_ENVIRONMENT);
$info = ob_get_clean();
$split = "Variable => Value\n";
$data = substr($info, strpos($info, $split) + count($split));
$data = explode("\n", $data);

array_map(function($row) {
    $split = ' => ';
    $p = strpos($row, $split);
    $key = substr($row, 0, $p);
    $value = substr($row, $p + count($split));
    if (!empty($key)) {
        $_ENV[$key] = $value;
    }
}, $data);

print_r($_ENV);
