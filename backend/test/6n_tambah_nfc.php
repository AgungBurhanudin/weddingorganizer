<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
    "interface": "NFC",
    "noid": "0010001000000003",
    "nama": "AHMAD",
    "alias": "NFC_IDA",
    "passw": "123456",
    "limit_trx": 20000
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
echo $url_request = BASE_URL . 'REQUEST/act/TABLE/tbl_member_channel_add/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
