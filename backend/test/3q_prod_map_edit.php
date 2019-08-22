<?php

header('Content-Type: application/json');
require_once 'config_url.php';
$detail = '{
		"product" : "PLN",
		"product_detail" :"POSTPAID",
		"biller" : "HPAY",
		"kode_h2h" : "PLN POSTPAID",
		"status" :"1",
		"provider" : "PLN",
		"hpp" :"100",
		"admin_bank" :"3000",
		"margin" :"100",
		"id" :"32"
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
echo $url_request = BASE_URL . 'REQUEST/act/TABLE/tbl_product_map_edit/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
