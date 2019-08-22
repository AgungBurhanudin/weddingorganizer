<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$param = array(
    'tipe' => 'CEKUSERNAME',
    'token' => '',
    'appid' => APPID,
    'website' => 'laporan'
);

$json_request = json_encode($param);
$url_request = BASE_URL . 'LOGIN/CEKUSERNAME/WEB';
$response = getCurlResult($url_request, $json_request);
$jrespon = json_decode($response);

echo $response;
