<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$param = array(
    'tipe' => 'LOGIN',
    'username' => USERNAME,
    'password' => PASSWORD,
    'token' => '',
    'appid' => APPID,
    'website' => 'laporan'
);

$json_request = json_encode($param);
$url_request = BASE_URL . 'LOGIN/LOGIN/MOBILE';
$response = getCurlResult($url_request, $json_request);
$jrespon = json_decode($response);

$_SESSION['noid'] = $jrespon->noid;
$_SESSION['token'] = $jrespon->token;

echo $response;
