<?php

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$nama_bulan = get_bulan(substr($jst->periode, 4, 2));
$tahun_tag = substr($jst->periode, 0, 4);
$noid = $obj->noid;
$judul_struk = 'STRUK PEMBAYARAN INDOVISION';
$idpel = $jst->idpel;
$ref = $jst->reff;
$vsn = $jst->vsn;
$nama = $jst->nama;
$contentTmp = '';
$periode = $nama_bulan." ".$tahun_tag;
$admin_bank = rupiah($jst->admin_bank);
$tagihan = rupiah($jst->tagihan);
$total_tagihan = rupiah($jst->total_tagihan);

$arrInfo =  explode("\n",wordwrap("INDOVISION MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBELIAN YANG SAH",35));
$pesan = explode("\n",wordwrap("TERIMA KASIH ATAS KEPERCAYAAN ANDA MEMBAYAR DI LOKET KAMI",35));

imagestring($im, 3, (imagesx($im) - 7.5 * strlen($judul_struk)) / 1.9, 110, $judul_struk, $black);
imagestring($im, 1, 18, 130, "ID PEL        : ", $black); imagestring($im, 1, strlen("ID PEL       : ")*6+5, 130, $idpel, $black);
imagestring($im, 1, 18, 140, "NAMA          : ", $black); imagestring($im, 1, strlen("ID PEL       : ")*6+5, 140, $nama, $black);
imagestring($im, 1, 18, 150, "PERIODE       : ", $black); imagestring($im, 1, strlen("ID PEL       : ")*6+5, 150, $periode, $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[0])) / 4, 170, $arrInfo[0], $black);
imagestring($im, 1, (imagesx($im) - 4.5 * strlen($arrInfo[1])) / 3, 180, $arrInfo[1], $black);
imagestring($im, 1, 18, 195, "TAGIHAN       : ", $black); imagestring($im, 1, strlen("ID PEL       : ")*6+5, 195, "Rp.".$tagihan, $black);
imagestring($im, 1, 18, 205, "ADMIN BANK    : ", $black); imagestring($im, 1, strlen("ID PEL       : ")*6+5, 205, "Rp.".$admin_bank, $black);
imagestring($im, 1, 18, 215, "TOTAL BAYAR   : ", $black); imagestring($im, 1, strlen("ID PEL       : ")*6+5, 215, "Rp.".$total_tagihan, $black);

imagestring($im, 1, (imagesx($im) - 3 * strlen($pesan[0])) / 3, 310, $pesan[0], $black);
imagestring($im, 1, (imagesx($im) - 2.5 * strlen($pesan[1])) / 3, 320, $pesan[1], $black);