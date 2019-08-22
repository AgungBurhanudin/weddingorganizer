<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
  "nama" : "Joko Maruf",
  "jenkel" : "Laki-Laki",
  "tanggal_lahir" : "1992-02-02",
  "status_sekolah" : "TIDAK",
  "keterangan" : "Lorem ipsum dolor",
  "tempat_lahir" : "Kab.Semarang",
  "id" : "4"

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
echo $url_request = BASE_URL . 'XREQUEST/act/XHRD/tbl_mutasi_anak/update/WEB';
$response = getCurlResult($url_request,$json_request);

echo '

';
echo $response;
