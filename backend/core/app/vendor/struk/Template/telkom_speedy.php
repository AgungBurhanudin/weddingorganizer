<?php

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;
$judul_struk = 'STRUK PEMBAYARAN TAGIHAN SPEEDY';

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

$pesan_lunas = "TELKOM MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBAYARAN YANG SAH";
$pesan = "TERIMA KASIH ATAS KEPERCAYAAN ANDA MEMBAYAR DI LOKET KAMI";


$arrInfo = explode("\n", wordwrap("TELKOM menyatakan struk ini sebagai bukti pembayaran yang sah, mohon disimpan.", 50, "\n"));

imagestring($im, 3, (imagesx($im) - 7 * strlen($judul_struk)) / 2, 110, $judul_struk, $black);
imagestring($im, 1, 18, 130, "ID PEL   : ", $black); imagestring($im, 1, strlen("NAMA PEL : ")*6+5, 130, $idpel, $black);
imagestring($im, 1, 18, 140, "NAMA PEL : ", $black); imagestring($im, 1, strlen("NAMA PEL : ")*6+5, 140, $nama, $black);
imagestring($im, 1, 18, 150, "BLN/THN  : ", $black); imagestring($im, 1, strlen("NAMA PEL : ")*6+5, 150, $bulan_tahun, $black);
imagestring($im, 1, 18, 160, "BILL REF : ", $black); imagestring($im, 1, strlen("NAMA PEL : ")*6+5, 160, $ref, $black);
imagestring($im, 1, 18, 170, "RP TAG   : ", $black); imagestring($im, 1, strlen("NAMA PEL : ")*6+5, 170, "Rp.".$tagihan, $black);

imagestring($im, 1, (imagesx($im) - 4 * strlen($arrInfo[0])) / 4, 185, $arrInfo[0], $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[1])) / 4, 195, $arrInfo[1], $black);

imagestring($im, 1, 18, 210, "ADMIN    : ", $black); imagestring($im, 1, strlen("NAMA PEL : ")*6+5, 210, "Rp.".$admin_bank, $black);
imagestring($im, 1, 18, 220, "TOTAL    : ", $black); imagestring($im, 1, strlen("NAMA PEL : ")*6+5, 220, "Rp.".$total_tagihan, $black);
