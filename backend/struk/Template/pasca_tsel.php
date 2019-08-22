<?php

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;
$judul_struk = explode("\n",wordwrap('STRUK PEMBAYARAN TAGIHAN KARTU HALO',20));
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

$arrConfirm = explode("\n", wordwrap("Simpan Struk ini Sebagai Bukti Pembayaran.", 50, "\n"));
$arrInfo = explode("\n", wordwrap("Terimakasih atas kepercayaan Anda membayar ke loket kami.", 35, "\n"));


$totalTag = 0;
if($lembar > 1){
	for($i=0; $i<$lembar; $i++)
	{
		$tag = (string)$tagihan;
		$totalTag = $totalTag + $tag;
		
		$noref = (string)$ref;

		$billRef = (string)$ref;

		$tgltok = "201".substr($billRef,0,1)."/".substr($billRef,1,2)."/".substr($billRef,3,2);
		$jamtok = (string)$ref;
	}
	$totalTag = $totalTag + $admin_bank;
} else {
	$tag = (string)$tagihan;
	$totalTag = $tag + $admin_bank;

	$noref = (string)$ref;

	$billRef = (string)$ref;

	$tgltok = "201".substr($billRef,0,1)."/".substr($billRef,1,2)."/".substr($billRef,3,2);
	$jamtok = (string)$ref;
}

imagestring($im, 3, (imagesx($im) - 7.5 * strlen($judul_struk[0])) / 1.9, 110, $judul_struk[0], $black);
imagestring($im, 3, (imagesx($im) - 7.5 * strlen($judul_struk[1])) / 1.9, 120, $judul_struk[1], $black);
imagestring($im, 2, 18, 140, "TANGGAL     : ", $black); imagestring($im, 2, strlen("JML TAGIHAN :")*6+25, 140, $tgltok, $black);
imagestring($im, 2, 18, 155, "NO KARTU    : ", $black); imagestring($im, 2, strlen("JML TAGIHAN :")*6+25, 155, substr($idpel, 0,strlen($idpel)-4) . "####", $black);
imagestring($im, 2, 18, 170, "NAMA PLG    : ", $black); imagestring($im, 2, strlen("JML TAGIHAN :")*6+25, 170, $nama, $black);
imagestring($im, 2, 18, 185, "JML TAGIHAN : ", $black); imagestring($im, 2, strlen("JML TAGIHAN :")*6+25, 185, "Rp.".$totalTag, $black);
imagestring($im, 1, (imagesx($im) - 4 * strlen($arrConfirm[0])) / 4, 210, $arrConfirm[0], $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[0])) / 4, 220, $arrInfo[0], $black);

