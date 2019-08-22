<?php

header('Content-Type: application/json');
require_once 'config_url.php';
$detail = '{
  "id" : "2",
  "nama_file" : "15197052822135.xlsx"
}';
$param = array(
    'detail' => json_decode($detail),
    'noid' => $_SESSION['noid'],
    'username' => USERNAME,
    'token' => $_SESSION['token'],
    'appid' => APPID
);

echo $json_request = json_encode ($param);
echo '

';
echo $url_request = BASE_URL . 'REQUEST/act/XBILLING/tbl_upload_file/WEB';
$response = getCurlResult($url_request,$json_request);

echo '

';
echo $response;
