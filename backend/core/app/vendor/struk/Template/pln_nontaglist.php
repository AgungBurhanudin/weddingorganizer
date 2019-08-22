<?php

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;
$judul_struk = 'STRUK NON TAGIHAN LISTRIK';

$jenis = $jst->jenis;
$no_reg = $jst->no_reg;
$tgl_reg = date("d-m-Y", strtotime($jst->tgl_reg));
$nama = $jst->nama;
$idpel = $jst->idpel;
$admin = rupiah($jst->admin);
$total = rupiah($jst->total);
$total_bayar = rupiah($jst->admin + $jst->total);
$noref = $jst->ref;
$vsn = $jst->vsn;

$arrConfirm = explode("\n", wordwrap("PLN menyatakan struk ini sebagai bukti pembayaran yang sah. Mohon Disimpan", 40, "\n"));
$arrInfo = explode("\n", wordwrap("Rincian tagihan dapat diakses di www.pln.co.id atau PLN terdekat Informasi Hubungi call center : 123", 35, "\n"));

imagestring($im, 3, (imagesx($im) - 7.5 * strlen("STRUK NON TAGIHAN LISTRIK")) / 1.9, 110, "STRUK NON TAGIHAN LISTRIK", $black);
imagestring($im, 1, 8, 130, "TRANSAKSI     : ", $black);
imagestring($im, 1, strlen("TRANSAKSI      : ") * 5 + 4, 130, $waktu, $black);
imagestring($im, 1, 8, 140, "NO REGISTRASI : ", $black);
imagestring($im, 1, strlen("NO REGISTRASI  : ") * 5 + 4, 140, $no_reg, $black);
imagestring($im, 1, 8, 150, "TGL REGISTRASI: ", $black);
imagestring($im, 1, strlen("TGL REGISTRASI : ") * 5 + 4, 150, $tgl_reg, $black);
imagestring($im, 1, 8, 160, "NAMA          : ", $black);
imagestring($im, 1, strlen("NAMA           : ") * 5 + 4, 160, $nama, $black);
imagestring($im, 1, 8, 170, "IDPEL         : ", $black);
imagestring($im, 1, strlen("IDPEL          : ") * 5 + 4, 170, $idpel, $black);
imagestring($im, 1, 8, 180, "BIAYA PLN     : ", $black);
imagestring($im, 1, strlen("BIAYA PLN      : ") * 5 + 4, 180, "Rp." . $total, $black);
imagestring($im, 1, 8, 190, "NO REF        : ", $black);
imagestring($im, 1, strlen("NO REF         : ") * 5 + 4, 190, $noref, $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($arrConfirm[0])) / 4, 205, $arrConfirm[0], $black);
imagestring($im, 1, (imagesx($im) - 3.5 * strlen($arrConfirm[1])) / 3, 215, $arrConfirm[1], $black);
imagestring($im, 1, 8, 240, "ADMIN BANK    : ", $black);
imagestring($im, 1, strlen("ADMIN BANK     : ") * 5 + 4, 240, "Rp." . $admin, $black);
imagestring($im, 1, 8, 250, "TOTAL BAYAR   : ", $black);
imagestring($im, 1, strlen("TOTAL BAYAR    : ") * 5 + 4, 250, "Rp." . $total_bayar, $black);
imagestring($im, 1, (imagesx($im) - 2 * strlen($arrInfo[0])) / 4, 275, $arrInfo[0], $black);
imagestring($im, 1, (imagesx($im) - 3.2 * strlen($arrInfo[1])) / 3, 285, $arrInfo[1], $black);
imagestring($im, 1, (imagesx($im) - 3.6 * strlen($arrInfo[2])) / 3, 295, $arrInfo[2], $black);
//imagestring($im, 1, 10, 255, $info, $black);
imagestring($im, 1, 15, 320, $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda, $black);
