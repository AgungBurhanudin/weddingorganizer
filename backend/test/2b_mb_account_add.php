<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
    "jenis": "MEMBER",
    "tipe": "M3",
    "nama": "MIZA ZAKI",
    "nik": "3373042512840005",
    "tgl_lahir": "1984-12-25",
    "alamat": "salatiga",
    "provinsi": "JAWA TENGAH",
    "kota_kabupaten": "KOTA SALATIGA",
    "kecamatan": "SIDOMUKTI",
    "kelurahan": "MANGUNSARI",
    "provinsi_value": "33",
    "kota_kabupaten_value": "3373",
    "kecamatan_value": "3373030",
    "kelurahan_value": "3373030003",
    "rt": "2",
    "rw": "11",
    "kodepos": "50721",
    "nohp_email": "ARIFARINTX3@DSYARIAH.CO.ID"
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
echo $url_request = BASE_URL . 'REQUEST/act/TABLE/tbl_member_account_add/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
