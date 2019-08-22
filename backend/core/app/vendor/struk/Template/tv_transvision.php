<?php

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;
$judul_struk = explode("\n", wordwrap("STRUK PEMBAYARAN TAGIHAN TRANSVISION",25));
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


$arrConfirm = explode("\n", wordwrap("Simpan Struk ini Sebagai Bukti Pembayaran.", 50, "\n"));
$arrInfo = explode("\n", wordwrap("Terimakasih atas kepercayaan Anda membayar ke loket kami.", 35, "\n"));

imagestring($im, 3, (imagesx($im) - 7.5 * strlen($judul_struk[0])) / 1.9, 110, $judul_struk[0], $black);
imagestring($im, 3, (imagesx($im) - 7.5 * strlen($judul_struk[1])) / 1.9, 120, $judul_struk[1], $black);
imagestring($im, 1, 18, 140, "ID PEL    : ", $black); imagestring($im, 1, strlen("ID PEL    : ")*6+5, 140, $idpel, $black);
imagestring($im, 1, 18, 150, "NAMA      : ", $black); imagestring($im, 1, strlen("ID PEL    : ")*6+5, 150, $nama, $black);
imagestring($im, 1, 18, 160, "PERIODE   : ", $black); imagestring($im, 1, strlen("ID PEL    : ")*6+5, 160, $bulan_tahun, $black);
imagestring($im, 1, 18, 170, "TAGIHAN   : ", $black); imagestring($im, 1, strlen("ID PEL    : ")*6+5, 170, $total_tagihan, $black);

imagestring($im, 1, (imagesx($im) - 4 * strlen($arrConfirm[0])) / 4, 185, $arrConfirm[0], $black);

imagestring($im, 1, 18, 200, "ADMIN    : ", $black); imagestring($im, 1, strlen("NAMA PEL : ")*6+5, 200, "Rp.".$admin_bank, $black);
imagestring($im, 1, 18, 210, "TOTAL    : ", $black); imagestring($im, 1, strlen("NAMA PEL : ")*6+5, 210, "Rp.".$total_tagihan, $black);
imagestring($im, 1, (imagesx($im) - 4 * strlen($arrInfo[0])) / 4, 230, $arrInfo[0], $black);
imagestring($im, 1, (imagesx($im) - 2 * strlen($arrInfo[1])) / 4, 240, $arrInfo[1], $black);
