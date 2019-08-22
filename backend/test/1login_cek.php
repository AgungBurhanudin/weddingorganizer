<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$param = array(
    'tipe' => 'LOGIN',
    'username' => USERNAME,
    'password' => PASSWORD,
    'token' => '',
    'appid' => APPID,
    'website' => 'transaksi'
);

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'LOGIN/LOGIN/WEB/OK';
$response = getCurlResult($url_request, $json_request);
$jrespon = json_decode($response);
echo '

';
$_SESSION['noid'] = $jrespon->noid;
$_SESSION['token'] = $jrespon->token;

echo $response;
