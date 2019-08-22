<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$param = array(
    'noid' => $_SESSION['noid'],
    'username' => USERNAME,
    'token' => $_SESSION['token'],
    'appid' => APPID
);

$random = 3;//randomMin(1);
if($random == 1){
    $jenis = 'TELKOM/TELEPON';
}elseif ($random == 2) {
    $jenis = 'TELKOM/SPEEDY';
}elseif ($random == 3) {
    $jenis = 'PLN/POSTPAID';
}elseif ($random == 4) {
    $jenis = 'PLN/NONTAGLIST';
}else{
    $jenis = 'BPJS/KESEHATAN';
}

//$idpel = randomNumber(12);
//$idpel = '8888001432048217';
$idpel = '552510000002';
//$idpel = '0298-313175';
$traceId = randomNumber(12);

echo $json_request = json_encode($param);
echo '
';
echo $url_request = BASE_URL . "TRXINQUIRY/act/$jenis/$idpel/$traceId/WEB";
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;

$jrep = json_decode($response);
$reff = $jrep->reff;
$url_request_pay = BASE_URL . "TRXPAYMENT/act/$traceId/$reff/WEB";
$response_pay = getCurlResult($url_request_pay, $json_request);

echo '

';
echo $response_pay;


