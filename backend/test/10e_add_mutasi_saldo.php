<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
	"waktu_proses" : "2011-01-11 00:02:00",
	"noid" : "0000000000010001",
	"id_account" : "88738274827",
	"detail" : "{}",
	"amount" : "2000",
	"saldo" : "10000",
	"stat" : "1"
  
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
echo $url_request = BASE_URL . 'REQUEST/act/XBANK/log_mutasi_saldo/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;


