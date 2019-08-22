<?php

$pdam = $obj->paylog;

$bulan = $pdam->content->pdamBillInfos->billPeriod;
$bulan = substr($bulan, 4, 5) . "/" . substr($bulan, 0, 4);;

$tagihan = $pdam->content->totalAmount + $admin;
$idpel = trim($pdam->content->subscriberId);
$nama = trim($pdam->content->subscriberName);

$produk = str_replace('_', ' ', $obj->product_detail);
$reff = $id_trx;

imagestring($im, 3, (imagesx($im) - 7.5 * strlen("PDAM ".$produk)) / 1.9, 110, "PDAM ".$produk, $black);
imagestring($im, 2, 18, 130, "NO. PELANGGAN : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+25, 130, $idpel, $black);
imagestring($im, 2, 18, 145, "NAMA          : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+25, 145, $nama, $black);
imagestring($im, 2, 18, 160, "PERIODE       : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+25, 160, $bulan, $black);
imagestring($im, 2, 18, 175, "TAGIHAN       : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+25, 175, "Rp".rupiah($tagihan), $black);

