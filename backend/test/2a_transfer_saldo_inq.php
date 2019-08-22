<?php

header('Content-Type: application/json');
require_once 'config_url.php';



$detail = '{
    "nohp_email": "EMAILKU@DSYARIAH.CO.ID",
    "action": "inq",
    "nominal": "25000",
    "keterangan": "COBA",
    "tujuan": "CASH"
  }';

$param = array(
    'detail' => json_decode($detail),
    'noid' => $_SESSION['noid'],
    'username' => USERNAME,
    'token' => $_SESSION['token'],
    'appid' => APPID
);

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'REQUEST/act/PROCESS/menu_transfer_saldo/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
