<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
  "noid" : "0000000000010001",
  "id_investasi" : "88738274827",
  "jenis" : "investasi",
  "saldo" : "500000",
  "jangka_waktu_bulan" : "10",
  "reg_date" :"2018-01-01",
  "jatuh_tempo" : "2019-01-01",
  "vsn" : "99898898",
  "status" : "1"
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
echo $url_request = BASE_URL . 'XREQUEST/act/XBANK/tbl_investasi/add/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
