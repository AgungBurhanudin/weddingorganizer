<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$param = array(
    'noid' => $_SESSION['noid'],
    'nohp_email' => USERNAME
);

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'REQUEST_OPEN/act/REQUEST_OPEN/cek_new_message/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
