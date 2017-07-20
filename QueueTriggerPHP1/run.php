<?php
$data = json_decode(file_get_contents(__DIR__.'/function.json'));
fwrite(STDOUT, print_r($data, true));
?>
