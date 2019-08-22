<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
    "id": 30,
    "nama": "PAIJO",
    "alias": "NFC_IDXX",
    "passw": "123123",
    "limit_trx": 5000
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
echo $url_request = BASE_URL . 'REQUEST/act/TABLE/tbl_member_channel_edit/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
