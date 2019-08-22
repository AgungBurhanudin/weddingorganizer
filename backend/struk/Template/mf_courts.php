<?php

$multifinance = $obj->paylog;
$inqXml = $obj->inqlog;

$tagihan = (int)$inqXml->content->totalAmount;
$nama = trim((string)$inqXml->content->namaPelanggan);

$idpel = (string)$multifinance->content->nomorPelanggan;

$terbilang = $tagihan + $admin;

imagestring($im, 3, (imagesx($im) - 7.5 * strlen("COURTS")) / 1.9, 110, "COURTS", $black);
imagestring($im, 2, 18, 130, "NO. REKENING : ", $black); imagestring($im, 2, strlen("NO. REKENING : ")*6+25, 130, $idpel, $black);
imagestring($im, 2, 18, 145, "NAMA         : ", $black); imagestring($im, 2, strlen("NO. REKENING : ")*6+25, 145, $nama, $black);
imagestring($im, 2, 18, 160, "TAGIHAN      : ", $black); imagestring($im, 2, strlen("NO. REKENING : ")*6+25, 160, "Rp".rupiah($terbilang), $black);

