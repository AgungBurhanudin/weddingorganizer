<?php
$pdam = $obj->paylog;

$tagihan = $pdam->content->total_tagihan + $admin;

$tgl_byr = $obj->waktu;
$tgl_byr = substr($tgl_byr, 8, 2) . "/" . substr($tgl_byr, 5, 2) . "/" . substr($tgl_byr, 0, 4);

$reff = $id_trx;

$produk = str_replace('_', ' ', $obj->product_detail);

$lembar = count($pdam->content->detail_tagihan);
$golongan = (string)$pdam->content->golongan;
$idpel = trim($pdam->content->idpel);
$nama = trim($pdam->content->nama);
				

if($lembar < 2){
	$period = $pdam->content->detail_tagihan->bulan .'-'.$pdam->content->detail_tagihan->tahun;
	$admin = (int)$pdam->content->detail_tagihan->adminBank;
	$rptag = (int)$pdam->content->detail_tagihan->rpTagihan;
	$totalTagihan = (int)$pdam->content->detail_tagihan->totalTagihan;
	
}else{
	$period ='';
	$admin = 0;
	$rptag = 0;
	$totalTagihan = 0;
	foreach($pdam->content->detail_tagihan as $row){
		
		$admin += (int)$row->adminBank;
		$rptag += (int)$row->rpTagihan;
		$totalTagihan += (int)$row->totalTagihan;
		$period .= $row->bulan .'-'.$row->tahun .',';
		
	}
	$period = substr($period,0,-1);
}				
				




$alamat = (int)$pdam->content->alamat;
$golongan = $pdam->content->golongan;
$ref = $pdam->content->reff;


imagestring($im, 3, (imagesx($im) - 7.5 * strlen("PDAM ".$produk)) / 1.9, 110, "PDAM ".$produk, $black);
imagestring($im, 2, 18, 130, "NO. PELANGGAN : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 130, $idpel, $black);
imagestring($im, 2, 18, 145, "NAMA          : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 145, $nama, $black);
imagestring($im, 2, 18, 160, "ALAMAT        : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 160, $alamat, $black);
imagestring($im, 2, 18, 175, "PERIODE       : ", $black); imagestring($im, 1, strlen("NO. PELANGGAN : ")*6+15, 178, $period, $black);
imagestring($im, 2, 18, 190, "LEMBAR        : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 190, $lembar, $black);
imagestring($im, 2, 18, 205, "GOLONGAN      : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 205, $golongan, $black);
imagestring($im, 2, 18, 220, "REFF          : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 220, $ref, $black);
imagestring($im, 2, 18, 235, "RP TAGIHAN    : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 235, "Rp".rupiah($rptag), $black);
imagestring($im, 2, 18, 250, "ADMIN         : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 250, "Rp".rupiah($admin), $black);
imagestring($im, 2, 18, 265, "TOTAL TAGIHAN : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 265, "Rp".rupiah($totalTagihan), $black);

imagestring($im, 1, 18, 285, "PPN DIBEBASKAN SESUAI PP NO: 12 THN 2001,", $black);
imagestring($im, 1, 18, 295, "         DIUBAH PP NO: 31 THN 2007", $black);

