<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
  "id_tabungan" : "88738274827",
  "nama_tabungan" : "ARIF ARIANTO",
  "jenis" : "tabungan",
  "saldo" : "200",
  "reg_date" :"2018-01-01",
  "last_date" : "2019-01-01",
  "vsn" : "99898898",
  "status" : "1",
  "last_trx" :"{}", 
  "last_amount" :"1"
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
echo $url_request = BASE_URL . 'XREQUEST/act/XBANK/tbl_tabungan/edit/WEB';
$response = getCurlResult($url_request,$json_request);

echo '

';
echo $response;
