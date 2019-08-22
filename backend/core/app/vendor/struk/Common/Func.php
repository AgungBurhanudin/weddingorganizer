<?php
function rupiah($price)
{
	$price = number_format($price + 0, 0, '', '.');
	return $price;
}

function rupiahd($rup)
{
	$rup = number_format($rup + 0, 2, ',', '.');
	return $rup;
}

function rupiaht($rup)
{
	$rup = number_format($rup + 0, 1, ',', '.');
	return $rup;
}

function rupiahb($rup)
{
	if ($rup < 2000000000)
	{
		$rups = number_format($rup + 0, 0, '', '.');
	}
	else
	{
		$rups = substr($rup, 0, 1) . '.' . substr($rup, 1, 3) . '.' . substr($rup, 4, 3) . '.' . substr($rup, 7, 3);
	}

	return $rups;
}

function get_bulan($bulan)
{
	switch ($bulan)
	{
		case '01': $nama_bulan = 'JAN'; break;
		case '02': $nama_bulan = 'FEB'; break;
		case '03': $nama_bulan = 'MAR'; break;
		case '04': $nama_bulan = 'APR'; break;
		case '05': $nama_bulan = 'MEI'; break;
		case '06': $nama_bulan = 'JUN'; break;
		case '07': $nama_bulan = 'JUL'; break;
		case '08': $nama_bulan = 'AGU'; break;
		case '09': $nama_bulan = 'SEP'; break;
		case '10': $nama_bulan = 'OKT'; break;
		case '11': $nama_bulan = 'NOV'; break;
		case '12': $nama_bulan = 'DES'; break;
		default  : $nama_bulan = '-';   break;
	}
	return $nama_bulan;
}

function get_bulan_lengkap($bulan)
{
	switch ($bulan)
	{
		case '01': $nama_bulan = 'JANUARI';   break;
		case '02': $nama_bulan = 'FEBRUARI';  break;
		case '03': $nama_bulan = 'MARET'; 	  break;
		case '04': $nama_bulan = 'APRIL'; 	  break;
		case '05': $nama_bulan = 'MEI'; 	  break;
		case '06': $nama_bulan = 'JUNI'; 	  break;
		case '07': $nama_bulan = 'JULI'; 	  break;
		case '08': $nama_bulan = 'AGUSTUS';   break;
		case '09': $nama_bulan = 'SEPTEMBER'; break;
		case '10': $nama_bulan = 'OKTOBER';   break;
		case '11': $nama_bulan = 'NOVEMBER';  break;
		case '12': $nama_bulan = 'DESEMBER';  break;
		default  : $nama_bulan = '-';         break;
	}
	return $nama_bulan;
}


// FUNGSI TERBILANG KE RUPIAH => http://harviacode.com/2014/09/23/membuat-fungsi-terbilang-php/
function kekata($x)
{
	$x = abs($x);
	$angka = array("", "satu", "dua", "tiga", "empat", "lima",
	"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($x <12) {
		$temp = " ". $angka[$x];
	} else if ($x <20) {
		$temp = self::kekata($x - 10). " belas";
	} else if ($x <100) {
		$temp = self::kekata($x/10)." puluh". self::kekata($x % 10);
	} else if ($x <200) {
		$temp = " seratus" . self::kekata($x - 100);
	} else if ($x <1000) {
		$temp = self::kekata($x/100) . " ratus" . self::kekata($x % 100);
	} else if ($x <2000) {
		$temp = " seribu" . self::kekata($x - 1000);
	} else if ($x <1000000) {
		$temp = self::kekata($x/1000) . " ribu" . self::kekata($x % 1000);
	} else if ($x <1000000000) {
		$temp = self::kekata($x/1000000) . " juta" . self::kekata($x % 1000000);
	} else if ($x <1000000000000) {
		$temp = self::kekata($x/1000000000) . " milyar" . self::kekata(fmod($x,1000000000));
	} else if ($x <1000000000000000) {
		$temp = self::kekata($x/1000000000000) . " trilyun" . self::kekata(fmod($x,1000000000000));
	}
		return $temp;
}


function terbilang($x, $style=4)
{
	if($x<0) {
		$hasil = "minus ". trim(self::kekata($x));
	} else {
		$hasil = trim(self::kekata($x));
	}
	switch ($style) {
		case 1:
			$hasil = strtoupper($hasil);
			break;
		case 2:
			$hasil = strtolower($hasil);
			break;
		case 3:
			$hasil = ucwords($hasil);
			break;
		default:
			$hasil = ucfirst($hasil);
			break;
	}
	return $hasil;
}
