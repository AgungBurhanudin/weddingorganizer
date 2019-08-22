<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$param = array(
    'id_device' => 'ARIFA19QBV'
);

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'REQUEST_DEVICE/CEKTOKENDEVICE/WEB';
$response = getCurlResult($url_request, $json_request);
$jrespon = json_decode($response);

$_SESSION['noid'] = $jrespon->noid;
$_SESSION['appid'] = $jrespon->appid;
echo '

';
echo $response;
