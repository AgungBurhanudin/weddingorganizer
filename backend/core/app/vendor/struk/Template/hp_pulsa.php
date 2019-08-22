<?php

$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;
$judul_struk = 'STRUK PEMBELIAN PULSA';
$idpel = $jst->idpel;
$ref = $jst->reff;
$vsn = $jst->vsn;
$contentTmp = '';

$tagihan = rupiah($jst->tagihan);
$admin_bank = rupiah($jst->admin_bank);
$total_tagihan = rupiah($jst->total_tagihan);
	

if ($obj->product_detail == "INDOSAT" || $obj->product_detail == "INDOSAT_OOREDOO_PAKET_DATA" || $obj->product_detail == "INDOSAT OOREDOO PAKET DATA") {
	if ((string) $obj->responseCode == "68" || (string) $obj->responseCode == "99") {
		$addMessage1 = "Transaksi anda sedang diproses";
		$addMessage2 = "Silahkan cek kuota anda atau hubungi customer service provider";
		$idpel = $idpel;
		$dateTrx = (string) $waktu;
		$noResi = (string) $ref;
	} else {
		$vsn = (string) $vsn;
		$idpel = (string) $idpel;
		$addMessage1 = "KUOTA AKAN BERTAMBAH SECARA OTOMATIS";
		$dateTrx = (string) $waktu;
		$noResi = (string) $ref;
	}
	$arrInfo = explode("\n", wordwrap($addMessage2, 35, "\n"));
} else {
	if (is_string($vsn)) {
		$vsn = (string) $vsn;
	} else {
		$vsn = (string) $ref;
	}
	$idpel = (string) $idpel;
}

if ($obj->product_detail == "INDOSAT" || $obj->product_detail == "INDOSAT_OOREDOO_PAKET_DATA" || $obj->product_detail == "INDOSAT OOREDOO PAKET DATA") {
	imagestring($im, 3, (imagesx($im) - 7.5 * strlen($obj->product_detail)) / 1.9, 110, str_replace("_", " ", $obj->product_detail), $black);
} else {
	imagestring($im, 3, (imagesx($im) - 7.5 * strlen("PULSA " . $obj->product_detail)) / 1.9, 110, "PULSA " . $obj->product_detail, $black);
}
imagestring($im, 2, 18, 130, "OPERATOR   : ", $black);
imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 130, $idpel, $black);

imagestring($im, 2, 18, 140, "NOMOR HP   : ", $black);
imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 140, $idpel, $black);
if ($obj->product_detail == "INDOSAT" || $obj->product_detail == "INDOSAT_OOREDOO_PAKET_DATA" || $obj->product_detail == "INDOSAT OOREDOO PAKET DATA") {
	imagestring($im, 2, 18, 155, "VSN : ", $black);
	imagestring($im, 2, strlen("VOUCHER SERIAL :") * 6 + 25, 155, $vsn, $black);
} else {
	if (is_string($vsn)) {
		imagestring($im, 2, 18, 155, "VSN: ", $black);
		imagestring($im, 2, 18, 170, $vsn, $black);
	} else {
		imagestring($im, 2, 18, 155, "VNS : ", $black);
		imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 155, $vsn, $black);
	}
}
if ($obj->product_detail == "INDOSAT" || $obj->product_detail == "INDOSAT_OOREDOO_PAKET_DATA" || $obj->product_detail == "INDOSAT OOREDOO PAKET DATA") {
	imagestring($im, 2, 18, 160, "TANGGAL    : ", $black);
	imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 160, $waktu, $black);
	imagestring($im, 2, 18, 175, "NOMOR RESI : ", $black);
	imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 175, $ref, $black);
	imagestring($im, 2, 18, 190, "NOMINAL    : ", $black);
	imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 190, "Rp " . $total_tagihan, $black);
	imagestring($im, 2, 18, 195, "ADMIN BANK : ", $black);
	imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 195, "Rp " . $admin_bank, $black);
	imagestring($im, 2, 18, 205, "TOTAL BAYAR: ", $black);
	imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 205, "Rp " . $total_tagihan, $black);
} else {
	imagestring($im, 2, 18, 185, "NOMINAL    : ", $black);
	imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 185, "Rp " . $tagihan, $black);
	imagestring($im, 2, 18, 195, "ADMIN BANK : ", $black);
	imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 195, "Rp " . $admin_bank, $black);
	imagestring($im, 2, 18, 205, "TOTAL BAYAR: ", $black);
	imagestring($im, 2, strlen("NOMOR RESI :") * 6 + 25, 205, "Rp " . $total_tagihan, $black);
}
if ($obj->product_detail == "INDOSAT" || $obj->product_detail == "INDOSAT_OOREDOO_PAKET_DATA" || $obj->product_detail == "INDOSAT OOREDOO PAKET DATA") {
	imagestring($im, 1, (imagesx($im) - 3 * strlen($addMessage1)) / 3, 290, $addMessage1, $black);
	imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[0])) / 3, 300, $arrInfo[0], $black);
	imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[1])) / 3, 310, $arrInfo[1], $black);
}


//. "\n".$judul_struk
//			. "\n--------------------------------"
//			. "\nOPERATOR    : " . $idpel
//			. "\nNOHP        : " . $idpel
//			. "\nVSN         : "
//			. "\n" . $vsn
//			. "\nNO REFF     : ". $ref
//			. "\nNOMINAL     : Rp." . $tagihan
//			. "\nADMIN BANK  : Rp." . $admin_bank
//			. "\nTOTAL BAYAR : Rp." . $total_tagihan