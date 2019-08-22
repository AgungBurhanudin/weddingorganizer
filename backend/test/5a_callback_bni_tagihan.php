<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
    "nomor_va": "VA000000000006",
    "noid": "123412342",
    "action": "exec",
    "nominal": "103000",
    "keterangan": "PEMBAYARAN TAGIHAN",
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
