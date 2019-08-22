<?php

$judul_struk = 'STRUK PEMBAYARAN BPJS KETENAGAKERJAAN';

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

imagestring($im, 3, (imagesx($im) - 7 * strlen("STRUK PEMBAYARAN")) / 2, 110, "STRUK PEMBAYARAN", $black);
imagestring($im, 3, (imagesx($im) - 7 * strlen("BPJS KETENAGAKERJAAN")) / 2, 120, "BPJS KETENAGAKERJAAN", $black);
imagestring($im, 1, 8, 140, "NO REFF       :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 140, $ref, $black);
imagestring($im, 1, 8, 150, "NO VA         :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 150, $idpel, $black);
imagestring($im, 1, 8, 160, "WAKTU         :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 160, $waktu, $black);
imagestring($im, 1, 8, 170, "NAMA          :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 170, $nama, $black);
imagestring($im, 1, 8, 180, "PERIODE       :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 180, $lembar." BULAN", $black);
imagestring($im, 1, 8, 195, "JUMLAH        :", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 195, "Rp.".$tagihan, $black);
 

imagestring($im, 1, (imagesx($im) - 5 * strlen("BPJS KETENAGAKERJAAN MENYATAKAN STRUK INI")) / 2, 220, "BPJS KETENAGAKERJAAN MENYATAKAN STRUK INI", $black);
imagestring($im, 1, (imagesx($im) - 5 * strlen("SEBAGAI BUKTI PEMBAYARAN YANG SAH")) / 2, 230, "SEBAGAI BUKTI PEMBAYARAN YANG SAH", $black);
imagestring($im, 1, (imagesx($im) - 5 * strlen("_______________________________________________")) / 1, 235, "______________________________________________", $black);

imagestring($im, 1, 8, 255, "ADMIN BANK    : ", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 255, "Rp.".$admin_bank, $black);
imagestring($im, 1, 8, 265, "TOTAL BAYAR   : ", $black); imagestring($im, 1, strlen("RP STROOM/TOKEN :")*5+3, 265, "Rp.".$total_tagihan, $black);
imagestring($im, 1, (imagesx($im) - 5.8 * strlen("Rincian tagihan dapat diakses melalui")) / 1, 310, "Rincian Tagihan dapat diakses melalui", $black);
imagestring($im, 1, (imagesx($im) - 6.5 * strlen("www.bpjs-ketenagakerjaan.go.id")) / 1, 320, "www.bpjs-ketenagakerjaan.go.id", $black);

