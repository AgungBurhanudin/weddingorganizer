<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
  "nama" : "arif arinto",
  "barang" : "motor bekas",
  "beli" : 10000000,
  "jangka_waktu" : 12,
  "dp" : 1000000
}';

$param = array(
  'detail' => json_decode($detail),
  'noid' => $_SESSION['noid'],
  'username' => USERNAME,
  'token' => $_SESSION['token'],
  'appid' => APPID
);

echo $json_request = json_encode ($param);
echo '

';
echo $url_request = BASE_URL . 'XREQUEST/act/XBANK/pro_kredit_simulasi/CEK/WEB';
$response = getCurlResult($url_request,$json_request);

echo '

';
echo $response;
