<?php
header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
	"action" : "inq/exec",
	"nohp_email": "0818181881",
	"nominal": "3000",
	"keterangan": "lorem ipsum dolor",
	"passw": "123123",
	"limit_trx": "20000"
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
echo $url_request = BASE_URL . 'REQUEST/act/PROCESS/menu_transfer_saldo/MOBILE';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;




  
