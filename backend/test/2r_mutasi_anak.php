<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$order[0]['dir'] = 'asc';
$search['value'] = '';

$param = array(
    'draw' => '1',
    'start' => '0',
    'length' => '10',
    'order' => $order,
    'search' => $search,
    'noid' => $_SESSION['noid'],
    'username' => USERNAME,
    'token' => $_SESSION['token'],
    'appid' => APPID
);

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'RPAGINGPOS/act/XHRD/rpaging_mutasi_anak/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
