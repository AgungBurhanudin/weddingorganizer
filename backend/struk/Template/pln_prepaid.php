<?php

$judul_struk = 'STRUK PEMBELIAN LISTRIK PRABAYAR';

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;

$nomor_meter = $jst->nomor_meter;
$idpel = $jst->idpel;
$nama = $jst->nama;
$segmen = $jst->segmen;
$daya = $jst->daya;
$stroom = rupiah($jst->stroom);
$kwh = $jst->kwh;
$vsn = $jst->vsn;
$ref = $jst->ref;
$angsuran = rupiah($jst->angsuran);
$meterai = rupiah($jst->meterai);
$ppn = rupiah($jst->ppn);
$ppj = rupiah($jst->ppj);
$admin = rupiah($jst->admin);
$total = rupiah($jst->total);
$info = $jst->info;
$arrInfo = explode("\n", wordwrap($info, 35, "\n"));

$token = $jst->token;
$tok1 = substr($token, 0, 4);
$tok2 = substr($token, 4, 4);
$tok3 = substr($token, 8, 4);
$tok4 = substr($token, 12, 4);
$tok5 = substr($token, 16, 4);
$new_token = $tok1 . " " . $tok2 . " " . $tok3 . " " . $tok4 . " " . $tok5;

//$content = printInk($idpel, $nomor_meter, $nama, $segmen, $daya, $ref, $angsuran, $admin, $meterai, $ppn, $ppj, $total, $stroom, $kwh, $new_token, $info, $noid, $waktu, $vsn, $provider, $penanda);

imagestring($im, 3, (imagesx($im) - 7 * strlen("STRUK PEMBELIAN LISTRIK PRABAYAR")) / 2, 110, "STRUK PEMBELIAN LISTRIK PRABAYAR", $black);
imagestring($im, 1, 8, 130, "NO METER       :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 130, $nomor_meter, $black);
imagestring($im, 1, 8, 140, "IDPEL          :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 140, $idpel, $black);
imagestring($im, 1, 8, 150, "NAMA           :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 150, $nama, $black);
imagestring($im, 1, 8, 160, "TARIF/DAYA     :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 160, $segmen."/".$daya."VA", $black);
imagestring($im, 1, 8, 170, "NO REF         :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 170, $ref, $black);
imagestring($im, 1, 8, 180, "RP BAYAR       :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 180, "Rp.".$total, $black);
imagestring($im, 1, 8, 190, "METERAI        :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 190, "Rp.".$meterai, $black);
imagestring($im, 1, 8, 200, "PPn            :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 200, "Rp.".$ppn, $black);
imagestring($im, 1, 8, 210, "PPj            :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 210, "Rp.".$ppj, $black);
imagestring($im, 1, 8, 220, "ANGSURAN       :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 220, "Rp.".$angsuran, $black);
imagestring($im, 1, 8, 230, "RP STROOM/TOKEN:", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 230, "Rp.".$stroom, $black);
imagestring($im, 1, 8, 240, "JML KWH        :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 240, $kwh, $black);
imagestring($im, 1, 8, 250, "STROOM/TOKEN   :", $black); 
imagestring($im, 3, 30, 260, $new_token, $black);
imagestring($im, 1, 8, 275, "ADMIN BANK     :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 275, "Rp.".$admin, $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[0])) / 4, 290, $arrInfo[0], $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[1])) / 3, 300, $arrInfo[1], $black);
imagestring($im, 1, 23, 320, $noid.'/'.$createdat.'/'.$vsn.'/'.$penanda, $black);

