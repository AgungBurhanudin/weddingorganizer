<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
	"noid" : "8989898",
	"waktu" : "2018-01-01",
	"noid_add" : "808080",
	"nama_add" : "joko maruf",
	"nohp_email_add" : "jokom@mail.com",
	"alamat_add" : "salatiga",
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

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'XREQUEST/act/XBANK/tbl_kredit_pengajuan/add/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
