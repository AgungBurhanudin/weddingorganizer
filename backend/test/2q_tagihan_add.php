<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$idtagihan = randomNumber(10);

$detail = '{
    "jenis_tagihan": "IMB",
    "idtagihan": "'.$idtagihan.'",
    "idtagihan_name": "IMB ARIF ARINTO",
    "jatuh_tempo": "2018-03-01",
    "tagihan": 100000,
    "admin": 3000
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
echo $url_request = BASE_URL . 'REQUEST/act/XBILLING/tbl_tagihan_add/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
