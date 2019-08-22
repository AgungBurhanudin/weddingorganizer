<?php

$judul_struk = 'STRUK PEMBAYARAN TAGIHAN LISTRIK';
$jst = json_decode($obj->struk);
$penanda = $obj->cetak == 1 ? 'CA' : 'CU';
$waktu = $obj->waktu;
$noid = $obj->noid;

$idpel = $jst->idpel;
$nama = $jst->nama;
$segmen = $jst->segmen;
$daya = $jst->daya;
$lembar = $jst->lembar;
$detail = $jst->detail[0];
$ref = $jst->reff;
$info = $jst->info;
$vsn = $jst->vsn;
$pesan_lunas = 'PLN MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBAYARAN YANG SAH';
$lembarProses = $lembar > 4 ? 4 : $lembar;

if ($lembar > 1) {
	$tagihan = 0;
	$totalbayar = 0;
	$totalAdmin = 0;
	$totalBayarPlusAdmin = 0;
	$tahun_tag = "";
	$bulan_tag = "";
	$nama_bulans = "";
	$period = "";
	$standmeter1 = "";
	$standmeter2 = "";
	$tunggakanKe = $lembar - 4;
	$idpel = $idpel;
	$nama = $nama;

	for ($x = 0; $x < $lembarProses; $x++) {
//		$totalbayar = $totalbayar
		//$totalAdmin = $totalAdmin + $admin_bank;
		$totalBayarPlusAdmin = $totalBayarPlusAdmin + $totalbayar;
		$tahun_tag = substr($detail->billPeriod, 2, 2);
		$bulan_tag = substr($detail->billPeriod, 4, 2);
		$nama_bulans = get_bulan($bulan_tag);
		$period = $period . $nama_bulans . $tahun_tag . ", ";
	}
	$tagihan = $tagihan + (int) $pln->content->totalAmount;
	$totalBayarPlusAdmin = (int) $pln->content->totalAmount + ($admin_bank * $lembarProses);
	$info = $info;
	$standmeter1 = $detail->standmeter1;
	$standmeter2 = $detail->standmeter2;
} else {
	$nama_bulan = get_bulan(substr($detail->billPeriod, 4, 2));
	$tahun_tag = substr($detail->billPeriod, 0, 4);
	$bulan_tag = substr($detail->billPeriod, 4, 2);
	$nama_bulans = get_bulan($bulan_tag);
	$period = $nama_bulans ."/". $tahun_tag;
	$standmeter1 = $detail->standmeter1;
	$standmeter2 = $detail->standmeter2;
	$tagihan = $detail->tagihan;
	$admin_bank = $detail->admin_bank;
	$totalBayarPlusAdmin = $tagihan + $admin_bank;
	$tunggakanKe = 0;
}
$arrInfo = explode("\n", wordwrap("PLN menyatakan struk ini sebagai bukti pembayaran yang sah.", 35, "\n"));

if ($tunggakanKe > 0) {
	$infoTunggakan = "Anda masih memiliki sisa tunggakan " . $tunggakanKe . " bulan|$info";
} else {
	$infoTunggakan = "TERIMA KASIH|$info";
}
$arrInfoTunggakan = explode("|", $infoTunggakan);

imagestring($im, 3, (imagesx($im) - 7 * strlen("STRUK PEMBAYARAN TAGIHAN LISTRIK")) / 2, 110, "STRUK PEMBAYARAN TAGIHAN LISTRIK", $black);
imagestring($im, 1, 8, 130, "IDPEL      :", $black);
imagestring($im, 1, strlen("STAND METER :") * 5 + 4, 130, $idpel, $black);
imagestring($im, 1, 8, 140, "NAMA       :", $black);
imagestring($im, 1, strlen("STAND METER :") * 5 + 4, 140, $nama, $black);
imagestring($im, 1, 8, 150, "TARIF/DAYA :", $black);
imagestring($im, 1, strlen("STAND METER :") * 5 + 4, 150, $segmen . "/" . $daya . "VA", $black);
imagestring($im, 1, 8, 160, "BL/TH      :", $black);
imagestring($im, 1,	 strlen("STAND METER :") * 5 + 4, 160, rtrim($period, ", "), $black);
imagestring($im, 1, 8, 170, "STAND METER:", $black);
imagestring($im, 1, strlen("STAND METER :") * 5 + 4, 170, $standmeter1 . '-' . $standmeter2, $black);
imagestring($im, 1, 8, 180, "RP TAG PLN :", $black);
imagestring($im, 1, strlen("STAND METER :") * 5 + 4, 180, "Rp." . rupiah($tagihan), $black);
imagestring($im, 1, 8, 190, "NO REF     :", $black);
imagestring($im, 1, strlen("STAND METER :") * 5 + 4, 190, $ref, $black);

imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[0])) / 4, 205, $arrInfo[0], $black);
imagestring($im, 1, (imagesx($im) - 3 * strlen($arrInfo[1])) / 3, 215, $arrInfo[1], $black);

imagestring($im, 1, 8, 235, "ADMIN BANK :", $black);
imagestring($im, 1, strlen("STAND METER :") * 5 + 4, 235, "Rp." . rupiah($admin_bank) * $lembarProses, $black);
imagestring($im, 1, 8, 245, "TOTAL BAYAR:", $black);
imagestring($im, 1, strlen("STAND METER :") * 5 + 4, 245, "Rp." . rupiah($totalBayarPlusAdmin), $black);

$y = 265;
$x = 0;
foreach ($arrInfoTunggakan as $arr) {
	if ($x == 1) {
		$c = explode("\n", wordwrap($arr, 30, "\n"));
		foreach ($c as $cs) {
			imagestring($im, 1, (imagesx($im) - 5 * strlen($cs)) / 2, $y, $cs, $black);
			$y = $y + 10;
		}
	} else {
		imagestring($im, 1, (imagesx($im) - 5 * strlen($arr)) / 2, $y, $arr, $black);
	}
	$y = $y + 10;
	$x++;
}

imagestring($im, 1, 7, 320, $noid . '/' . $createdat . '/' . $vsn . '/' . $penanda, $black);

