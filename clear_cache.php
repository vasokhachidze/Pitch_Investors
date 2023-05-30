<?php
$output = shell_exec("php artisan optimize 2>&1");
echo $output;
?>
