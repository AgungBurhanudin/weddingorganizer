<?php

header('Content-Type: application/json');
require_once 'config_url.php';



$detail = '{
    "tanggal": "2018-02-15"
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

echo $url_request = BASE_URL . 'REQUEST/act/REPORT/web_mutasi_saldo_hari_detail/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
