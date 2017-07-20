<?php
fwrite(STDOUT, "run.php on root");
fwrite(STDOUT, print_r($_SERVER, true));
fwrite(STDOUT, print_r($_ENV, true));
