<?php
	$test = "Hallo0";
	//Header
	imagestring($im, 3, 18, 90, "Tagihan       #$id_pembayaran" , $black);
	imagestring($im, 2, 18, 100, "Tanggal Tagihan : $tanggal_tagihan", $black);
	imagestring($im, 2, 18, 110, "Jatuh Tempo     : $jatuh_tempo", $black);

	//Kepada
	imagestring($im, 3, 18, 130, "Kepada : $nama_wali" , $black);
	imagestring($im, 2, 18, 140, "Alamat  : $alamat", $black);
	imagestring($im, 2, 18, 150, "No Hp   : $nohp_wali", $black);

	//header table
	imagestring($im, 2, 18, 167, "Deskripsi", $black);
	imagestring($im, 2, strlen("Deskripsi") * 6 + 200, 167, "Total", $black);

	//isi table
	//$line = 187;
	//foreach ($pembayaran as $key => $value) {
		imagestring($im, 2, 18, 187, $nama_tagihan, $black);
		imagestring($im, 2, strlen("TANGGAL") * 6 + 200, 187, "Rp. ".number_format($total_bayar,2), $black);		

	//	$line = $line+13;
	//}

	imagestring($im, 2, 18, 200, "Sisa Tagihan", $black);
	imagestring($im, 2, strlen("TANGGAL") * 6 + 200, 200, "Rp. ". number_format($sisa_tagihan, 2), $black);


	//riwayat table header
	imagestring($im, 2, 18, 310, "Tanggal Bayar", $black);
	imagestring($im, 2, strlen("Tanggal Bayar") * 6 + 50, 310, "Keterangan", $black);
	imagestring($im, 2, strlen("Tanggal Bayar") * 6 + 170, 310,"Total Bayar", $black);

	//isi riwayat	
	$line = 330;
	foreach ($riwayat as $key => $value) {
		imagestring($im, 2, 18, 330, $value['tanggal_bayar'], $black);
		imagestring($im, 2, strlen($value['tanggal_bayar']) * 6 + 75, 330, $value['keterangan'], $black);
		imagestring($im, 2, strlen($value['tanggal_bayar']) * 6 + 180, 330, "Rp. ". number_format($value['total_bayar'],2)	, $black);

		$line = $line + 15;
	}

	// imagestring($im, 1, (imagesx($im) - 3 * strlen($addMessage1)) / 3, 290, $addMessage1, $black);
	// imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[0])) / 3, 300, $arrInfo[0], $black);
	// imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[1])) / 3, 310, $arrInfo[1], $black);


