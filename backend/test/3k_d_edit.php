<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$idpel = randomNumber(12);
$detail = '{
    "id": "3",
	"idpel_new": "'.$idpel.'",
	"id_group": 1
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
echo $url_request = BASE_URL . 'REQUEST/act/TABLE/tbl_group_kolektifdetail_edit/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
