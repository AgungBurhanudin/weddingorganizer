<?php

// $jst = json_decode($obj->struk);
// $judul_struk = 'STRUK PEMBELIAN PULSA';
$contentTmp = '';
	
$test = "123456";
	//Header
	imagestring($im, 3, 18, 90, "Tagihan #idtagihan" , $black);
	imagestring($im, 2, 18, 100, "Tanggal Tagihan", $black);
	imagestring($im, 2, 18, 110, "Jatuh Tempo", $black);

	//Kepada
	imagestring($im, 3, 18, 130, "Kepada #idtagihan" , $black);
	imagestring($im, 2, 18, 140, "Alamat", $black);
	imagestring($im, 2, 18, 150, "No Hp", $black);

	//header table
	imagestring($im, 2, 18, 167, "TANGGAL", $black);
	imagestring($im, 2, strlen("TANGGAL") * 6 + 200, 167, $test, $black);

	//isi table
	imagestring($im, 2, 18, 187, "TANGGAL", $black);
	imagestring($im, 2, strlen("TANGGAL") * 6 + 200, 187, $test, $black);

	imagestring($im, 2, 18, 200, "TANGGAL", $black);
	imagestring($im, 2, strlen("TANGGAL") * 6 + 200, 200, $test, $black);


	//riwayat table header
	imagestring($im, 2, 18, 310, "TANGGAL", $black);
	imagestring($im, 2, strlen("TANGGAL") * 6 + 75, 310, "Tagihan", $black);
	imagestring($im, 2, strlen("TANGGAL") * 6 + 200, 310,"Nominal", $black);

	//isi riwayat	
	imagestring($im, 2, 18, 330, "TANGGAL", $black);
	imagestring($im, 2, strlen("TANGGAL") * 6 + 75, 330, "Tagihan", $black);
	imagestring($im, 2, strlen("TANGGAL") * 6 + 200, 330, "Nominal"	, $black);

	// imagestring($im, 1, (imagesx($im) - 3 * strlen($addMessage1)) / 3, 290, $addMessage1, $black);
	// imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[0])) / 3, 300, $arrInfo[0], $black);
	// imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[1])) / 3, 310, $arrInfo[1], $black);



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