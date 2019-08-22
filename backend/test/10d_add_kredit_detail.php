<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
	"id_tbl_kredit" : "111111",
	"anoid" : "8989898",
	"nama" : "jack",
	"barang" : "Motor",
	"beli" : "15000000",
	"jangka_waktu" : "12",
	"dp" : "30"

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
echo $url_request = BASE_URL . 'XREQUEST/act/XBANK/tbl_kredit_detail/add/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
