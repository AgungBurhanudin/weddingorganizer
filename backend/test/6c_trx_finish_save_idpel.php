<?php

header('Content-Type: application/json');
require_once 'config_url.php';
//$noid = randomNumber(10);

$detail = '{
  "action" : "add",
  "product" : "lorem ipsum",
  "product_detail" : "lorem ipsum dolor",
  "idpel" : "89",
  "nama" : "lorem ipsum"
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
echo $url_request = BASE_URL . 'REQUEST/act/REPORT/mob_daftar_idpel/MOBILE';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
