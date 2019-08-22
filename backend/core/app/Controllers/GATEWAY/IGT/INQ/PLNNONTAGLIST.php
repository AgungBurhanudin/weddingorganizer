<?php

$tagihan = 20000;
$total_tagihan = $tagihan + $admin_bank;
$lembar = 1;
$idpel_name = 'COBA';
$jenis_transaksi = 'KENAIKAN DAYA';

$jh = array();
$jh[0][0] = 'PEMBAYARAN' ;$jh[0][1] = $product.' '.$product_detail;
$jh[1][0] = 'NO REGISTRASI';$jh[1][1] = $idpel;
$jh[2][0] = 'TRANSAKSI'  ;$jh[2][1] = $jenis_transaksi;
$jh[3][0] = 'NAMA'  ;$jh[3][1] = $idpel_name;
$jh[4][0] = 'RP TAG'  ;$jh[4][1] = $tagihan;
$jh[5][0] = 'ADMIN BANK'  ;$jh[5][1] = $admin_bank;
$jh[6][0] = 'TOTAL BAYAR'  ;$jh[6][1] = $total_tagihan;
$response_html = $fHtml->jsonToHtml($jh);

$response_code = '0000';
