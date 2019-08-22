<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
  "tanggal_kenaikan" : "2011-02-12",
  "no_sk" : "001/001/2019",
  "gaji" : "6000000",
  "tanggal_penempatan" : "2017-01-01",
  "ket_penempatan" : "lorem ipsum dolor",
  "masa_kerja" : "2",
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
echo $url_request = BASE_URL . 'XREQUEST/act/XHRD/tbl_mutasi_kg/update/WEB';
$response = getCurlResult($url_request,$json_request);

echo '

';
echo $response;
