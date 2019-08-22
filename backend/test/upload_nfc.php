<?php
header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
	"detail" : {
	"interface" : "NFC",
	"noid": "0000000000010003",
	"nama": "JOKO123",
	"alias": "JOKO123",
	"passw": "123123",
	"limit_trx": "20000"
	}
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
echo $url_request = BASE_URL . '/UPLOAD_NFC/MOBILE';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;




  
