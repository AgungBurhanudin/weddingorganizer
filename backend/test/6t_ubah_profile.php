<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
    "noid": "0000000000010003",
	"nama" :"joko",
	"nik" :"3322022140101990003",
	"tgl_lahir" :"1999-01-01",
	"alamat" :"salatiga",
	"provinsi" :"jawa tengah",
	"provinsi_value" :"33",
	"kota_kabupaten" :"Semarang",
	"kota_kabupaten_value" :"2202",
	"kecamatan" :"Tengaran",
	"kecamatan_value" :"3322022",
	"kelurahan" :"klero",
	"kelurahan_value" :"3322022",
	"rt" :"15",
	"Rw" :"04",
	"kodepos" : "50775"
  }';
$param = array(
    'detail' => json_decode($detail),
    'noid' => $_SESSION['noid'],
    'username' => USERNAME,
    'token' => $_SESSION['token'],
    'appid' => APPID,
	
);

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'REQUEST/act/TABLE/tbl_member_account_edit/MOBILE';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
