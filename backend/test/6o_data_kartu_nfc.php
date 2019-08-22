<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$param = array(
    'noid' => $_SESSION['noid'],
    'username' => USERNAME,
    'token' => $_SESSION['token'],
    'appid' => APPID
);

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'REQUEST/act/REPORT/mob_data_nfc/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
