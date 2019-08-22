<?php

header('Content-Type: application/json');
require_once 'config_url.php';
$id_mutasi = randomNumber(10);
$detail = '{
    "id_mutasi" : "' . $id_mutasi . '",
    "nama": "Joko Maruf",
    "pangkat": "2B",
    "tempat_lahir": "Kab.Semarang",
    "tanggal_lahir" : "tes",
    "agama": "islam",
    "ijasah": "s1",
    "ijasah_a": "2017",
    "ijasah_b": "9",
    "jabatan": "Guru",
    "alamat": "Ds.klero Rt 15 rw 09 kec.tengaran, kab.semarang",
    "nama_istri_suami" : "melati",
    "tempat_lahir_istri_suami" : "kab.semarang",
    "tanggal_lahir_istri_suami" : "2001-09-09",
    "agama_istri_suami": "islam",
    "tgl_nikah_istri_suami": "2010-01-01",
    "pekerjaan_istri_suami": "wiraswasta",
    "foto_ktp" : "ambil image name hasil Upload Image",
    "foto_ijasah" : "ambil image name hasil Upload Image"
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
echo $url_request = BASE_URL . 'XREQUEST/act/XHRD/tbl_mutasi/add/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

  ';
echo $response;
