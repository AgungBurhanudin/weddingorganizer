<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
		"perintah" : "testing_menu",
		"hak_akses" :"",
		"aturan" : {"":""},
		"validasi" : "",
		"status" :"1",
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
echo $url_request = BASE_URL . 'REQUEST/act/TABLE/tbl_menu_add/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
