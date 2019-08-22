<?php

$obj2 = json_decode(str_replace('{}','""',$content));
$pdam = $obj2->paylog->content;


$produk = str_replace('_', ' ', $obj->product_detail);
$lembar = (int)$pdam->lembar_tagihan;
$golongan = $pdam->golongan;
$idpel = $pdam->idpel;
$nama = $pdam->nama;
$alamat = $pdam->alamat;
$ref = $pdam->reff;



$period =$pdam->bulan_tagihan;
$adminBank =(int)$pdam->admin_bank;

$arr_ket = explode("|", (string)$pdam->detail_tagihan->beban3);
$ket = count($arr_ket)>1?$arr_ket[1]:'';

$danaMeter = 0;			
$bebanTetap = 0;
$totalTagihan = 0;	
$totalBayar = 0;

if($lembar < 2){
	
	$danaMeter = (int)$pdam->detail_tagihan->danaMeter;			
	$bebanTetap = (int)$pdam->detail_tagihan->beban1 + (int)$pdam->detail_tagihan->beban2 + (int)$admin;
	$totalTagihan = (int)$pdam->detail_tagihan->totalTagihan;	
	$totalBayar = $adminBank + $danaMeter + (int)$pdam->detail_tagihan->ppn + $bebanTetap + (int)$pdam->detail_tagihan->materai + $totalTagihan;
	
}else{
	
	foreach($pdam->detail_tagihan as $row){
		
		$danaMeter += (int)$row->danaMeter;			
		$bebanTetap += (int)$row->beban1 + (int)$row->beban2 + (int)$admin;
		$totalTagihan += (int)$row->totalTagihan;	
		$totalBayar += $adminBank + $danaMeter + (int)$row->ppn + $bebanTetap + (int)$row->materai + $totalTagihan;
	}
	
}



imagestring($im, 3, (imagesx($im) - 7.5 * strlen("PDAM ".$produk)) / 1.9, 110, "PDAM ".$produk, $black);
imagestring($im, 2, 18, 130, "NO. PELANGGAN : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 130, $idpel, $black);
imagestring($im, 2, 18, 145, "NAMA          : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 145, $nama, $black);
imagestring($im, 2, 18, 160, "ALAMAT        : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 160, $alamat, $black);
imagestring($im, 2, 18, 175, "GOLONGAN      : ", $black); imagestring($im, 1, strlen("NO. PELANGGAN : ")*6+15, 178, $golongan, $black);
imagestring($im, 2, 18, 190, "LEMBAR        : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 190, $lembar, $black);
imagestring($im, 2, 18, 205, "PERIODE       : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 205, $period, $black);
imagestring($im, 2, 18, 220, "REFF          : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 220, $ref, $black);
imagestring($im, 2, 18, 235, "BEBAN TETAP   : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 235, "Rp".rupiah($bebanTetap), $black);
imagestring($im, 2, 18, 250, "DANA METER    : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 250, "Rp".rupiah($danaMeter), $black);
imagestring($im, 2, 18, 265, "ADMIN BANK    : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 265, "Rp".rupiah($adminBank), $black);
imagestring($im, 2, 18, 280, "TOTAL TAGIHAN : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 280, "Rp".rupiah($totalTagihan), $black);
imagestring($im, 2, 18, 295, "TOTAL BAYAR   : ", $black); imagestring($im, 2, strlen("NO. PELANGGAN : ")*6+15, 295, "Rp".rupiah($totalBayar), $black);

imagestring($im, 1, 18, 315, $ket, $black);
//imagestring($im, 1, 18, 295, "         DIUBAH PP NO: 31 THN 2007", $black);

