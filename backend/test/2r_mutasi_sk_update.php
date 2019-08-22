<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
  "tgl_sk" : "2017-02-02",
  "nomor_sk" : "001/001/2018",
  "golongan" : "2a",
  "tahun" : "2017",
  "bulan" : "01",
  "gaji" : "400000",
  "keterangan" : "lorem ipsum dolor",
  "id" : "2"
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
echo $url_request = BASE_URL . 'XREQUEST/act/XHRD/tbl_mutasi_sk/update/WEB';
$response = getCurlResult($url_request,$json_request);

echo '

';
echo $response;
