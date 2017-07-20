<?php
ob_start();
echo 'test';
fwrite(STDOUT, 'test');
$result = ob_get_clean();
echo $result;
