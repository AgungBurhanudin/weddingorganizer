<?php

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;
$judul_struk = 'STRUK PEMBAYARAN TAGIHAN TELKOM';

$idpel = $jst->idpel;
$nama = $jst->nama;
$lembar = $jst->lembar;
$ref = $jst->reff;
$vsn = $jst->vsn;
$contentTmp = '';

$bulan_tahun = $jst->bulan_tahun;
$tagihan = rupiah($jst->tagihan);
$admin_bank = rupiah($jst->admin_bank);
$total_tagihan = rupiah($jst->total_tagihan);

$arrConfirm = explode("\n", wordwrap("TELKOM menyatakan struk ini sebagai bukti pembayaran yang sah. Mohon Disimpan", 40, "\n"));
$arrInfo = explode("\n", wordwrap("Terimakasih atas kepercayaan Anda membayar ke loket kami.", 35, "\n"));


imagestring($im, 3, (imagesx($im) - 7 * strlen($judul_struk)) / 1.9, 110, $judul_struk, $black);
imagestring($im, 1, 18, 130, "NO JASTEL      : ", $black); imagestring($im, 1, strlen("NO JASTEL    : ")*6+20, 130, $idpel, $black);
imagestring($im, 1, 18, 140, "NAMA           : ", $black); imagestring($im, 1, strlen("NAMA         : ")*6+20, 140, $nama, $black);
imagestring($im, 1, 18, 150, "REF            : ", $black); imagestring($im, 1, strlen("REF          : ")*6+20, 150, $ref, $black);
imagestring($im, 1, 18, 160, "TAGIHAN        : ", $black); imagestring($im, 1, strlen("TAGIHAN      : ")*6+20, 160, "Rp.".$tagihan, $black);
imagestring($im, 1, 18, 170, "JML BULAN      : ", $black); imagestring($im, 1, strlen("JML BULAN    : ")*6+20, 170, $lembar." Bulan", $black);
imagestring($im, 1, 18, 180, "PERIODE        : ", $black); imagestring($im, 1, strlen("PERIODE      : ")*6+20, 180, $bulan_tahun, $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($arrConfirm[0])) / 4, 205, $arrConfirm[0], $black);
imagestring($im, 1, (imagesx($im) - 3.5 * strlen($arrConfirm[1])) / 3, 215, $arrConfirm[1], $black);
imagestring($im, 1, 18, 230, "BIAYA ADMIN    : ", $black); imagestring($im, 1, strlen("BIAYA ADMIN : ")*6+20, 230, "Rp.".$admin_bank, $black);
imagestring($im, 1, 18, 240, "TOTAL BAYAR    : ", $black); imagestring($im, 1, strlen("TOTAL BAYAR : ")*6+20, 240, "Rp.".$total_tagihan, $black);
imagestring($im, 1, (imagesx($im) - 2 * strlen($arrInfo[0])) / 4, 310, $arrInfo[0], $black);
imagestring($im, 1, (imagesx($im) - 2 * strlen($arrInfo[1])) / 3, 320, $arrInfo[1], $black);

//imagestring($im, 1, 18, 140, "NAMA           : ", $black); imagestring($im, 1, strlen("VOUCHER SERIAL : ")*6+20, 140, $nama, $black);
//imagestring($im, 1, 18, 150, "REF            : ", $black); imagestring($im, 1, strlen("VOUCHER SERIAL : ")*6+20, 150, $waktu, $black);
//imagestring($im, 1, 18, 160, "NOMOR TELEPON  : ", $black); imagestring($im, 1, strlen("VOUCHER SERIAL : ")*6+20, 160, $idpel, $black);
//imagestring($im, 1, 18, 150, "VOUCHER SERIAL : ", $black); imagestring($im, 2, 18, 160	, $vsn, $black);
//imagestring($im, 1, 18, 175, "NOMINAL        : ", $black); imagestring($im, 1, strlen("VOUCHER SERIAL : ")*6+20, 175, "Rp.".rupiah($tagihan), $black);
