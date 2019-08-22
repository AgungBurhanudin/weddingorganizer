<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
    "nominal": "25000",
    "admin_bank": "0"
  }';

$param = array(
    'detail' => json_decode($detail),
    'noid' => $_SESSION['noid'],
    'username' => USERNAME,
    'token' => $_SESSION['token'],
    'appid' => APPID
);

$random = 1;//randomMin(1);
if($random == 1){
    $jenis = 'PULSA/XL25';
}elseif ($random == 2) {
    $jenis = 'PLN/PREPAID';
}elseif ($random == 3) {
    $jenis = 'PULSA/INDOSAT';
}elseif ($random == 4) {
    $jenis = 'PULSA/TELKOMSEL';
}else{
    $jenis = 'PULSA/THREE';
}

//$idpel = randomNumber(12);
$idpel = '081712341234';
$traceId = randomNumber(12);

echo $json_request = json_encode($param);
echo '
';
echo $url_request = BASE_URL . "TRXINQUIRY/act/$jenis/$idpel/$traceId/WEB";
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
echo '

';
$jrep = json_decode($response);
$reff = $jrep->reff;
echo $url_request_pay = BASE_URL . "TRXPAYMENT/act/$traceId/$reff/WEB";
$response_pay = getCurlResult($url_request_pay, $json_request);

echo '

';
echo $response_pay;


