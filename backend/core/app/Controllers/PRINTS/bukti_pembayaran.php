<?php
require_once '../app/vendor/dompdf/dompdf_config.inc.php';
$folder_save   = '../../public/struk/';
$dompdf        = new Dompdf();
$id_pembayaran = "123";
$content       = "Testing PDF Gan";
$html          = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
$dompdf->load_html($html);
$paper_orientation = 'Potrait';
$dompdf->set_paper($paper_orientation);
$dompdf->render();

$pdf_string = $dompdf->output();
@unlink($folder_save . 'bukti_pembayaran_' . $id_pembayaran . '.pdf');

@file_put_contents($folder_save . 'bukti_pembayaran_' . $id_pembayaran . '.pdf', $pdf_string);
