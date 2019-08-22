<?php
error_reporting(E_ALL);
ini_set('diplay_errors','1');
require_once 'dompdf/dompdf_config.inc.php';
$main_url          = 'http://akucek.com/kartujajan';
$dompdf            = new Dompdf();
$paper_orientation = 'Potrait';

$jenis         = $_GET['jenis'];
$id_pembayaran = $_GET['id_pembayaran'];

$data          = file_get_contents($main_url . '/daemon/core/public/index.php/PRINTS/DOCUMENTS/DOTMATRIX/buktiPembayaran-000?id=' . $id_pembayaran . "&jenis=" . $jenis);
// echo $main_url . '/daemon/core/public/index.php/PRINTS/DOCUMENTS/DOTMATRIX/buktiPembayaran-000?id=' . $id_pembayaran;
// $data          = json_decode($data, true);

if (empty($id_pembayaran)) {
    $response = array(
        'response_code'    => "0000",
        'response_message' => "Data Tidak Di temukan",
    );
    die(json_encode($response));
}
// ob_start();
 if ($jenis == "paid") {
     include 'paid.php';
 } else {
     include 'unpaid.php';
}
$html = $data;
// $html = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
$dompdf->load_html($html);
$dompdf->set_paper($paper_orientation);
$dompdf->render();
$title = "Tagihan";
if ($jenis == "paid") {
    $title = "Bukti Pembayaran Tagihan";
} else {
    $title = "Tagihan";
}
$temp = $dompdf->output();

$im = new imagick($temp);
$im->setImageFormat( "jpg" );
$img_name = time().'.jpg';
$im->setSize(300,200);
$im->writeImage($img_name);
$im->clear();
$im->destroy(); 
// $pdf_string = $dompdf->output();
//@unlink($folder_save . 'bukti_pembayaran_' . $id_pembayaran . '.pdf');

// @file_put_contents($folder_save . 'bukti_pembayaran_' . $id_pembayaran . '.pdf', $pdf_string);
// $content = $folder_save . 'bukti_pembayaran_' . $id_pembayaran . '.pdf';
