<?php

$spc = $obj->paylog;

if ($obj->product_detail == "UNIV. MUHAMMADIYAH ACEH PMB")
{
	
	$tagihan = (int)$spc->content->totalTagihan;
	$namaspc = (string)$spc->content->namaSpc;
	$nim = (string)$spc->content->nim;
	$nama = (string)$spc->content->nama;
	$password = (string)$spc->content->reff;
	$totaltag = $tagihan + $admin;
	
	$arrNamaspc = explode("\n", wordwrap($namaspc, 25, "\n"));
	
	imagestring($im, 3, (imagesx($im) - 7.5 * strlen($arrNamaspc[0])) / 2, 110, $arrNamaspc[0], $black);
	imagestring($im, 3, (imagesx($im) - 7.5 * strlen($arrNamaspc[1])) / 2, 120, $arrNamaspc[1], $black);
	//imagestring($im, 3, (imagesx($im) - 7.5 * strlen($namaspc)) / 1.9, 110, $namaspc, $black);
	
	imagestring($im, 2, 18, 140, "NIM      : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*5+25, 140, $nim, $black);
	imagestring($im, 2, 18, 155, "USERNAME : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*5+25, 155, $nama, $black);
	imagestring($im, 2, 18, 170, "PASSWORD : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*5+25, 170, $password, $black);
	if ((int) $admin > 0) {
		imagestring($im, 2, 18, 185, "ADMIN    : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*5+25, 185, "Rp".rupiah($admin), $black);
		imagestring($im, 2, 18, 200, "TAGIHAN  : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*5+25, 200, "Rp".rupiah($totaltag), $black);
	} else {
		imagestring($im, 2, 18, 185, "TAGIHAN  : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*5+25, 185, "Rp".rupiah($totaltag), $black);
	}
}
else if ($obj->product_detail == "PESANTREN JEUMALA AMAL ACEH")
{
	$rincianTag = "";
	$tags = explode("||||", (string)$spc->content->detail_sekolah->iuranWajib);
	foreach ($tags as $idx => $tag)
	{
		$bulan = explode("|||", $tag);
		$rincianTag .= '<tr>
			<td><b>TAGIHAN '.$bulan[0].'</b></td>
			<td></td>
			<td colspan="2"></td>
		</tr>';

		$rincian = explode(",", $bulan[1]);
		foreach ($rincian as $idx => $r)
		{
			$arrR = explode("||", $r);
			$rincianTag .= '<tr>
				<td>'.$arrR[0].'</td>
				<td>: Rp.</td>
				<td colspan="2" style="text-align:right;">'.Libraries\Common\Func::rupiah($arrR[1]).'</td>
			</tr>';
		}
	}

	$tagihan = (int)$spc->content->totalTagihan;
	$namaspc = (string)$spc->content->namaSpc;
	$nim = (string)$spc->content->nim;
	$nama = (string)$spc->content->nama;
	$password = (string)$spc->content->reff;
	$totaltag = $tagihan + $admin;
	
	$arrNamaspc = explode("\n", wordwrap($namaspc, 25, "\n"));
	
	imagestring($im, 3, (imagesx($im) - 7.5 * strlen($arrNamaspc[0])) / 2, 110, $arrNamaspc[0], $black);
	imagestring($im, 3, (imagesx($im) - 7.5 * strlen($arrNamaspc[1])) / 2, 120, $arrNamaspc[1], $black);
	//imagestring($im, 3, (imagesx($im) - 7.5 * strlen($namaspc)) / 1.9, 110, $namaspc, $black);
	
	imagestring($im, 2, 18, 140, "NIM     : ", $black); imagestring($im, 2, strlen("TAGIHAN : ")*5+25, 140, $nim, $black);
	imagestring($im, 2, 18, 155, "NAMA    : ", $black); imagestring($im, 2, strlen("TAGIHAN : ")*5+25, 155, $nama, $black);
	if ((int) $admin > 0) {
		imagestring($im, 2, 18, 185, "ADMIN   : ", $black); imagestring($im, 2, strlen("TAGIHAN : ")*5+25, 185, "Rp".rupiah($admin), $black);
		imagestring($im, 2, 18, 200, "TAGIHAN : ", $black); imagestring($im, 2, strlen("TAGIHAN : ")*5+25, 200, "Rp".rupiah($totaltag), $black);
	} else {
		imagestring($im, 2, 18, 185, "TAGIHAN : ", $black); imagestring($im, 2, strlen("TAGIHAN : ")*5+25, 185, "Rp".rupiah($totaltag), $black);
	}
}
else
{	
	$tagihan = (int)$spc->content->totalTagihan;
	$namaspc = (string)$spc->content->namaSpc;
	$nim = (string)$spc->content->nim;
	$nama = (string)$spc->content->nama;
	$fakultas = (string)$spc->content->fakultas;
	$jurusan = (string)$spc->content->jurusan;
	$totaltag = $tagihan + $admin;
	
	imagestring($im, 3, (imagesx($im) - 7.5 * strlen($namaspc)) / 1.9, 110, $namaspc, $black);
	imagestring($im, 2, 18, 130, "NIM      : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*6+25, 130, $nim, $black);
	imagestring($im, 2, 18, 145, "NAMA     : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*6+25, 145, $nama, $black);
	imagestring($im, 2, 18, 160, "FAKULTAS : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*6+25, 160, $fakultas, $black);
	imagestring($im, 2, 18, 175, "JURUSAN  : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*6+25, 175, $jurusan, $black);
	imagestring($im, 2, 18, 190, "TAGIHAN  : ", $black); imagestring($im, 2, strlen("FAKULTAS : ")*6+25, 190, "Rp".rupiah($totaltag), $black);

}
