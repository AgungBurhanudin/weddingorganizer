<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
  "alias": "ARIFAR1234NFC"	
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
echo $url_request = BASE_URL . 'REQUEST/act/TABLE/tbl_member_channel_check/NFC';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;



