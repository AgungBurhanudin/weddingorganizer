<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
		"id_tbl_kredit" : "111111",
		"jml_angsuran" : "3"
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
echo $url_request = BASE_URL . 'XREQUEST/act/XBANK/tbl_kredit_detail/pay/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
