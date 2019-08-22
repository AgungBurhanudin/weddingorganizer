<?php
$file = $_GET['file'];
$image = 'C:\\logs\\'.$file;
header('Content-Type: image/x-png');
readfile($image);
die();
