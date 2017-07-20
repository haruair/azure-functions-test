<?php
ob_start();
phpinfo(INFO_ENVIRONMENT);
$info = ob_get_clean();
$data = substr($info, strpos($info, "Variable => Value\n"));
$data = explode("\n", $data);
echo $data;
