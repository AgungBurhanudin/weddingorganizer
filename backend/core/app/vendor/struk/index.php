<?php

date_default_timezone_set("Asia/Jakarta");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//error_reporting(0);

require_once("Common/Func.php");
$main_url          = 'http://localhost/TKI/GIT';

$id_trx = filter_input(INPUT_GET, 'id');
$jenis         = $_GET['jenis'];
$id_pembayaran = $_GET['id'];

$obj          = file_get_contents($main_url . '/daemon/core/public/index.php/PRINTS/DOCUMENTS/DOTMATRIX/buktiPembayaran-000?id=' . $id_pembayaran . "&jenis=" . $jenis);
// echo $main_url . '/daemon/core/public/index.php/PRINTS/DOCUMENTS/DOTMATRIX/buktiPembayaran-000?id=' . $id_pembayaran . "&jenis=" . $jenis;
// print_r($obj);
// exit();
// $url = MAIN_URL . 'framework/core/public/index.php/PRINTS/REQUEST/IMAGE/' . $id_trx;
// $content = file_get_contents($url);
$obj = json_decode($obj);


$createdat = date('Y-m-d');//date_format(date('Y-m-d'), "Y-m-d H:i:s");

$footer = "RESI INI ADALAH";
$footer1 = "BUKTI PEMBAYARAN YANG SAH";
$im = imagecreatefrompng("images/unpaid.png");
$black = imagecolorallocate($im, 0, 0, 0);
$grey = imagecolorallocate($im, 211, 211, 211);

// imagestring($im, 1, (imagesx($im) - 4 * strlen($id_trx)) / 2, 85, $id_trx, $black);
// imagestring($im, 1, (imagesx($im) - 5 * strlen($createdat)) / 2, 95, $createdat, $black);
include 'Template/invoice.php';



imagestring($im, 1, (imagesx($im) + 20 ) / 3, imagesy($im) - 25, $footer, $black);
imagestring($im, 1, (imagesx($im) + 50 ) / 5, imagesy($im) - 15, $footer1, $black);

// echo $id_struk = $obj->product . $obj->product_detail . $id_trx;
$image = 'tmp_struk/' . $id_pembayaran . '.png';
imagepng($im, $image);
imagedestroy($im);
//
header("Content-type: image/png");
readfile($image);
?>
