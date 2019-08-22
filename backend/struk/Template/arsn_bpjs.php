<?php

$judul_struk = 'STRUK PEMBAYARAN BPJS KESEHATAN';

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;

$idpel = $jst->idpel;
$nama = $jst->nama;
$lembar = $jst->lembar;
$ref = $jst->reff;
$vsn = $jst->vsn;
$tagihan = rupiah($jst->tagihan);
$admin_bank = rupiah($jst->admin_bank);
$total_tagihan = rupiah($jst->total_tagihan);
$contentTmp = '';
		
//$content = printInk($idpel, $nomor_meter, $nama, $segmen, $daya, $ref, $angsuran, $admin, $meterai, $ppn, $ppj, $total, $stroom, $kwh, $new_token, $info, $noid, $waktu, $vsn, $provider, $penanda);

imagestring($im, 3, (imagesx($im) - 7 * strlen("STRUK PEMBAYARAN BPJS KESEHATAN")) / 2, 110, "STRUK PEMBAYARAN BPJS KESEHATAN", $black);
imagestring($im, 1, 8, 130, "NO REFF       :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 130, $ref, $black);
imagestring($im, 1, 8, 140, "NO VA         :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 140, $idpel, $black);
imagestring($im, 1, 8, 150, "WAKTU         :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 150, $waktu, $black);
imagestring($im, 1, 8, 160, "NAMA          :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 160, $nama, $black);
imagestring($im, 1, 8, 170, "PERIODE       :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 170, $lembar." BULAN", $black);
imagestring($im, 3, 8, 185, "JUMLAH    :", $black); imagestring($im, 3, strlen("RP STROOM/TOKEN :")*5+3, 185, "Rp.".$tagihan, $black);
 

imagestring($im, 1, (imagesx($im) - 5 * strlen("BPJS KESEHATAN MENYATAKAN STRUK INI")) / 2, 210, "BPJS KESEHATAN MENYATAKAN STRUK INI", $black);
imagestring($im, 1, (imagesx($im) - 5 * strlen("SEBAGAI BUKTI PEMBAYARAN YANG SAH")) / 2, 220, "SEBAGAI BUKTI PEMBAYARAN YANG SAH", $black);
imagestring($im, 1, (imagesx($im) - 5 * strlen("_______________________________________________")) / 1, 225, "______________________________________________", $black);

imagestring($im, 3, 8, 245, "ADMIN BANK: ", $black); imagestring($im, 3, strlen("RP STROOM/TOKEN :")*5+3, 245, "Rp.".$admin_bank, $black);
imagestring($im, 3, 8, 265, "TOTAL     : ", $black); imagestring($im, 3, strlen("RP STROOM/TOKEN :")*5+3, 265, "Rp.".$total_tagihan, $black);
imagestring($im, 1, (imagesx($im) - 5.8 * strlen("Rincian tagihan dapat diakses melalui")) / 1, 300, "Rincian Tagihan dapat diakses melalui", $black);
imagestring($im, 1, (imagesx($im) - 7.5 * strlen("www.bpjs-kesehatan.go.id")) / 1, 310, "www.bpjs-kesehatan.go.id", $black);

