<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
	"action" : "inq",
	"alias" : "ARIFAR1234NFC",
	"passw" : "123123",
	"nominal" : "1000",
	"keterangan" : ""
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
echo $url_request = BASE_URL . 'REQUEST/act/PROCESS/menu_cash_out_nfc/NFC';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
