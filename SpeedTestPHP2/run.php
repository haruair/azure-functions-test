<?php
ob_start();
phpinfo(INFO_ENVIRONMENT);
$info = ob_get_clean();
$data = substr($info, strpos($info, "Variable => Value\n"));
$data = explode("\n", $data);

print_r($data);

$data = substr($info, strpos($info, "Variable => Value\r\n"));
$data = explode("\r\n", $data);

print_r($data);
