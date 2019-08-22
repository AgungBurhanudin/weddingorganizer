<?php

header('Content-Type: application/json');
require_once 'config_url.php';



$detail = '{
    "alias": "NFC_ID",
    "action": "inq",
    "passw": "",
    "nominal": 1200,
    "keterangan": "COBA"
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
echo $url_request = BASE_URL . 'REQUEST/act/PROCESS/menu_cash_out_nfc/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
