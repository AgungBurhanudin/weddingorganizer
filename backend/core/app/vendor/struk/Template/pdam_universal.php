<?php

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;
$judul_struk = 'STRUK PEMBAYARAN PDAM';
$idpel = $jst->idpel;
$nama = $jst->nama;
$lembar = $jst->lembar;
$ref = $jst->reff;
$vsn = $jst->vsn;
$alamat = $jst->alamat;
$golongan = $jst->golongan;
$nama_bulan = get_bulan(substr($jst->bln_thn, 4, 2));
$tahun_tag = substr($jst->bln_thn, 0, 4);
$denda = rupiah($jst->denda);
$tagihan = rupiah($jst->tagihan);
$admin_bank = rupiah($jst->admin_bank);
$total_tagihan = rupiah($jst->total_tagihan);

$arrInfo = explode("\n",  wordwrap("PDAM MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBAYARAN YANG SAH",35));
$pesan = explode("\n",  wordwrap("TERIMA KASIH ATAS KEPERCAYAAN ANDA MEMBAYAR DI LOKET KAMI",35));

				
/* if($lembar > 1){
	$period = "";
	$totPemakaian = 0;
	$totTagihan = 0;
	for ($i = 0; $i < $lembar; $i++) {
		$bulan = (string)$pdam->content->detilTagihan[$i]->bulan;
		$tahun = (string)$pdam->content->detilTagihan[$i]->tahun;
		$pemakaian = (int)$pdam->content->detilTagihan[$i]->meterDipakai;
		$tagihan = (int)$pdam->content->detilTagihan[$i]->totalTagihan;
		
		$period = $period.$bulan.$tahun." ";
		$totPemakaian = $totPemakaian + $pemakaian;
		$totTagihan = $totTagihan + $tagihan;
	}
	$hrgair = $pdam->content->detilTagihan->hargaAir;
	$admin = $pdam->content->detilTagihan->adminBank;
	$bbnttp = $pdam->content->detilTagihan->bebanAlat;
	$danamtr = $pdam->content->detilTagihan->danaMeter;
	$denda = $pdam->content->detilTagihan->denda;
	$materai = $pdam->content->detilTagihan->materai;
	$tagihan = $pdam->content->detilTagihan->totalTagihan + $admin;
} else { */
//}
imagestring($im, 3, (imagesx($im) - 7.5 * strlen("PDAM ")) / 1.9, 110, "PDAM ", $black);
imagestring($im, 2, 18, 130, "NO. PELANGGAN : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 130, $idpel, $black);
imagestring($im, 2, 18, 145, "NAMA          : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 145, $nama, $black);
imagestring($im, 2, 18, 160, "ALAMAT        : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 160, $alamat, $black);
imagestring($im, 2, 18, 175, "PERIODE       : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 175, $nama_bulan."/".$tahun_tag, $black);
imagestring($im, 2, 18, 190, "GOLONGAN      : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 190, $golongan, $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[0])) / 4, 215, $arrInfo[0], $black);
imagestring($im, 1, (imagesx($im) - 1 * strlen($arrInfo[1])) / 4, 225, $arrInfo[1], $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($pesan[0])) / 4, 240, $pesan[0], $black);
imagestring($im, 1, (imagesx($im) - 0.5 * strlen($pesan[1])) / 4, 250, $pesan[1], $black);
imagestring($im, 2, 18, 265, "DENDA         : ", $black); imagestring($im, 2, strlen("DENDA         : ")*6+15, 265, "Rp.".$denda, $black);
imagestring($im, 2, 18, 275, "ADMIN         : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 275, "Rp.".$admin_bank, $black);
imagestring($im, 2, 18, 285, "RP TAGIHAN    : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 285, "Rp.".$tagihan, $black);
imagestring($im, 2, 18, 300, "REFF          : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 300, $ref, $black);
imagestring($im, 2, 18, 315, "TOTAL TAGIHAN : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 315, "Rp.".rupiah($total_tagihan), $black);

