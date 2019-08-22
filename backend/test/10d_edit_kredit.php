<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
	"id_kredit" : "123345",
	"jenis" : "angsuran",
	"jpemohon" :"{}",
	"jbarang" :"{}",
	"jjaminan" :"{}",
	"beli" :"90909",
	"margin" :"1",
	"margin_awal" :"2",
	"jual" :"1000",
	"down_payment" :"111",
	"jangka_waktu" :"1",
	"reg_date" :"2019-01-01",
	"collect" :"loren",
	"cicilan" :"200",
	"cicilan_pokok" :"100",
	"cicilan_margin" :"100",
	"sisa_pinjaman" :"100",
	"saldo" :"5000",
	"tanggal_akad" :"2019-09-10",
	"id_investasi" : "123413445"
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
echo $url_request = BASE_URL . 'XREQUEST/act/XBANK/tbl_kredit/edit/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
