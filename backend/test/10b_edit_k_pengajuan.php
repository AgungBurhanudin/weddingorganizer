<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
	"noid_add" : "808080",
	"waktu" : "2019-02-02",
	"nama_add" : "jackzhouse",
	"nohp_email_add" : "jokomaruf@gmail.com",
	"alamat_add" : "semarang",
	"pengajuan" : "{}",
	"analisa" : "{}",
	"supplier" : "{}",
	"jaminan" : "{}",
	"dokumen" : "{}"
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
echo $url_request = BASE_URL . 'XREQUEST/act/XBANK/tbl_kredit_pengajuan/edit/WEB';
$response = getCurlResult($url_request,$json_request);

echo '

';
echo $response;
