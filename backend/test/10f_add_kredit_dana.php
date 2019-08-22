<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
	"waktu" : "2018-01-01",
	"id_tbl_kredit" : "111111",
	"id_investasi" : "909090909090",
	"nominal_dana" :"25000",
	"persentase_dana" :"50"
	
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
echo $url_request = BASE_URL . 'XREQUEST/act/XBANK/tbl_kredit_dana/add/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
