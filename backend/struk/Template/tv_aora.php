<?php

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;
$judul_struk = 'STRUK PEMBAYARAN AORA TV';
$idpel = $jst->idpel;
$ref = $jst->reff;
$vsn = $jst->vsn;
$nama = $jst->nama;
$contentTmp = '';
$namaPaket = $jst->namaPaket;
$kodetv = $jst->kodeTv;

$admin_bank = rupiah($jst->admin_bank);
$tagihan = rupiah($jst->tagihan);
$total_tagihan = rupiah($jst->total_tagihan);

$arrInfo =  explode("\n",wordwrap(" TV AORA MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBELIAN YANG SAH",35));
$pesan = explode("\n",wordwrap("TERIMA KASIH ATAS KEPERCAYAAN ANDA MEMBAYAR DI LOKET KAMI",35));

imagestring($im, 3, (imagesx($im) - 7.5 * strlen($judul_struk)) / 1.9, 110, $judul_struk, $black);
imagestring($im, 1, 18, 130, "ID PEL         : ", $black); imagestring($im, 1, strlen("KODE AORA TV   : ")*6+5, 130, $idpel, $black);
imagestring($im, 1, 18, 140, "NAMA           : ", $black); imagestring($im, 1, strlen("KODE AORA TV   : ")*6+5, 140, $nama, $black);
imagestring($im, 1, 18, 150, "PAKET          : ", $black); imagestring($im, 1, strlen("KODE AORA TV   : ")*6+5, 150, $namaPaket, $black);
imagestring($im, 1, 18, 170, "NO REF         : ", $black); imagestring($im, 1, strlen("KODE AORA TV   : ")*6+5, 170, $ref, $black);
imagestring($im, 1, 18, 180, "KODE AORA TV   : ", $black); imagestring($im, 1, strlen("KODE AORA TV   : ")*6+5, 180, $kodetv, $black);

imagestring($im, 1, (imagesx($im) - 2 * strlen($arrInfo[0])) / 4, 200, $arrInfo[0], $black);
imagestring($im, 1, (imagesx($im) - 4 * strlen($arrInfo[1])) / 3, 210, $arrInfo[1], $black);
imagestring($im, 1, 18, 235, "TAGIHAN        : ", $black); imagestring($im, 1, strlen("KODE AORA TV   : ")*6+5, 235, $tagihan, $black);
imagestring($im, 1, 18, 245, "ADMIN BANK     : ", $black); imagestring($im, 1, strlen("KODE AORA TV   : ")*6+5, 245, $admin_bank, $black);
imagestring($im, 1, 18, 255, "TOTAL BAYAR    : ", $black); imagestring($im, 1, strlen("KODE AORA TV   : ")*6+5, 255, $total_tagihan, $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($pesan[0])) / 3, 310, $pesan[0], $black);
imagestring($im, 1, (imagesx($im) - 2.5 * strlen($pesan[1])) / 3, 320, $pesan[1], $black);
