<?php

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = (string) $jst->hari_bulan;
$waktu = substr($waktu, 6, 2) . " " . get_bulan(substr($waktu, 4, 2)) . " " . substr($waktu, 0, 4);
$jams = (string) $jst->jamBerangkat;
$jams = substr($jams, 0, 2) . ":" . substr($jams, 2, 2);
$noid = $obj->noid;
$vsn = $jst->vsn;
$judul_struk = 'STRUK PEMBAYARAN KERETA API';
$idpel = $jst->idpel;
$nama = $jst->nama;
$train_name = $jst->train;
$train_no = $jst->train_no;
$ref = $jst->reff;
$seat = (string) $jst->seats;
$tripInfo = $jst->tripInfo[0];
$from = (string) $tripInfo->from;
$to = (string) $tripInfo->to;
$jmlPenumpang = (int) $tripInfo->jmlPenumpang;
$kelas = (string) $tripInfo->kelas;

$tagihan = rupiah($jst->tagihan);
$admin_bank = rupiah($jst->admin_bank);
$total_bayar = rupiah($jst->total_tagihan);

$contentTmp = '';
$arrInfo = explode("\n",wordwrap("TUKARKAN STRUK DENGAN TIKET DI STASIUN ONLINE PALING LAMBAT 1 JAM SEBELUM KEBERANGKATAN",35));
$pesan = explode("\n",wordwrap("INFO LEBIH LANJUT  HUBUNGI CONTACT  CENTER KAI 121",30));

	
imagestring($im, 3, (imagesx($im) - 7 * strlen($judul_struk)) / 1.9, 110, $judul_struk, $black);
imagestring($im, 1, 18, 130, "KODE BOOKING  : ", $black); imagestring($im, 1, strlen("KODE BOOKING   : ")*6+5, 130, $vsn, $black);
imagestring($im, 1, 18, 140, "NO BAYAR      : ", $black); imagestring($im, 1, strlen("NO BAYAR       : ")*6+5, 140, $idpel, $black);
imagestring($im, 1, 18, 150, "NAMA PENUMPANG: ", $black); imagestring($im, 1, strlen("NAMA           : ")*6+5, 150, $nama, $black);
imagestring($im, 1, 18, 160, "NO KERETA     : ", $black); imagestring($im, 1, strlen("NO KERETA      : ")*6+5, 160, $train_no, $black);
imagestring($im, 1, 18, 170, "NAMA KERETA   : ", $black); imagestring($im, 1, strlen("NAMA KERETA    : ")*6+5, 170, $train_name, $black);
imagestring($im, 1, 18, 180, "NO KURSI      : ", $black); imagestring($im, 1, strlen("NO KURSI       : ")*6+5, 180, $seat,$black);
imagestring($im, 1, 18, 190, "TGL/JAM       : ", $black); imagestring($im, 1, strlen("TGL/JAM        : ")*6+5, 190, $waktu ."/". $jams,$black);
imagestring($im, 1, 18, 200, "RUTE          : ", $black); imagestring($im, 1, strlen("RUTE           : ")*6+5, 200, $from . '-' . $to, $black);
imagestring($im, 1, 18, 210, "NO REFF       : ", $black); imagestring($im, 1, strlen("NO REFF        : ")*6+5, 210, $ref, $black);
imagestring($im, 1, (imagesx($im) - 2 * strlen($arrInfo[0])) / 4, 230, $arrInfo[0], $black);
imagestring($im, 1, (imagesx($im) - 4 * strlen($arrInfo[1])) / 3, 240, $arrInfo[1], $black);
imagestring($im, 1, (imagesx($im) - 2 * strlen($arrInfo[2])) / 3, 250, $arrInfo[2], $black);
imagestring($im, 2, 18, 265, "JML BAYAR   : ", $black); imagestring($im, 2, strlen("JML BAYAR      : ")*6+5, 265, "Rp.".$tagihan, $black);
imagestring($im, 2, 18, 275, "ADMIN       : ", $black); imagestring($im, 2, strlen("ADMIN          : ")*6+5, 275,"Rp.".$admin_bank, $black);
imagestring($im, 2, 18, 285, "TOTAL BAYAR : ", $black); imagestring($im, 2, strlen("TOTAL BAYAR    : ")*6+5, 285, "Rp.".$total_bayar, $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($pesan[0])) / 3, 310, $pesan[0], $black);
imagestring($im, 1, (imagesx($im) - 2.5 * strlen($pesan[1])) / 3, 320, $pesan[1], $black);