<?php

header('Content-Type: application/json');
require_once 'config_url.php';



$detail = '{
    "nomor_va": "8612000000000004",
    "noid": "0020000000000000",
    "action": "exec",
    "nominal": "25000",
    "keterangan": "TOPUP_VA",
    "tujuan": "BNIS"
  }';

$param = array(
    'detail' => json_decode($detail),
    'noid' => '0000000000010001',
    'username' => 'ARIFAR123',
    'token' => 'WWZXP8RDWV75AKWJS6UX',
    'appid' => '1RLXE27DNYKXFPTN'
);

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'REQUEST_H2H/act/PROCESS/service_callback_bni/H2H';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
