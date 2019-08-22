<?php

$tagihan = 20000;
$total_tagihan = $tagihan + $admin_bank;
$jumlah_peserta = 2;
$lembar = 1;
$idpel_name = 'COBA BPJS KESEHATAN';

$jh = array();
$jh[0][0] = 'PEMBAYARAN' ;$jh[0][1] = $product.' '.$product_detail;
$jh[1][0] = 'NOMOR PESERTA';$jh[1][1] = $idpel;
$jh[2][0] = 'NAMA PESERTA';$jh[2][1] = $idpel_name;
$jh[3][0] = 'JUMLAH PESERTA';$jh[3][1] = $jumlah_peserta;
$jh[4][0] = 'JUMLAH BULAN'  ;$jh[4][1] = $lembar.' Bulan';
$jh[5][0] = 'SISA SEBELUMNYA'  ;$jh[5][1] = 0;
$jh[6][0] = 'TAGIHAN'  ;$jh[6][1] = $tagihan;
$jh[7][0] = 'ADMIN BANK'  ;$jh[7][1] = $admin_bank;
$jh[8][0] = 'TOTAL TAGIHAN'  ;$jh[8][1] = $total_tagihan;
$response_html = $fHtml->jsonToHtml($jh);

$response_code = '0000';
