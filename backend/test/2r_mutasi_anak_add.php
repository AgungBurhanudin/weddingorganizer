<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
  "nama" : "Diana",
  "jenkel" : "Perempuan",
  "tempat_lahir" : "Kab.Semarang",
  "tanggal_lahir" : "2010-01-01",
  "status_sekolah" :"Sekolah",
  "keterangan" : "Lorem Ipsum dolor",
  "id_mutasi" : "7213445486"
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
echo $url_request = BASE_URL . 'XREQUEST/act/XHRD/tbl_mutasi_anak/add/WEB';
$response = getCurlResult($url_request,$json_request);

echo '

';
echo $response;
