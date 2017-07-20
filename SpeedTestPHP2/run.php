<?php
ob_start();
phpinfo(INFO_ENVIRONMENT);
$info = ob_get_clean();
$data = substr($info, strpos($info, "Variable => Value". PHP_EOL));
$data = explode(PHP_EOL, $data);

print_r($data);
