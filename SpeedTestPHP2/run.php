<?php
ob_start();
phpinfo(INFO_ENVIRONMENT);
$info = ob_get_clean();
$data = substr($info, strpos($info, "Variable => Value\n"));
$data = explode("\n", $data);

array_map(function($row) {
    $p = strpos($row, ' => ');
    $key = substr($row, 0, $p);
    $value = substr($row, $p + 3);
    $_ENV[$key] = $value;
}, $data);

print_r($_ENV);
