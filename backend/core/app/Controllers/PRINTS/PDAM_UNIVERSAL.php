<?php

$fungsi = new Libraries\Fungsi();
$config = new Libraries\Konfigurasi();
$fungsiHtml = new Libraries\FungsiHtml();

$jst = json_decode($arr_trx->struk);
$penanda = $arr_trx->cetak == 1 ? 'CA' : 'CU';
$waktu = $arr_trx->waktu;
$noid = $arr_trx->noid;
$judul_struk = 'STRUK PEMBAYARAN PDAM';
$idpel = $jst->idpel;
$nama = $jst->nama;
$lembar = $jst->lembar;
$ref = $jst->reff;
$vsn = $jst->vsn;
$alamat = $jst->alamat;
$denda = $fungsi->rupiah($jst->denda);
$golongan = $jst->golongan;
$nama_bulan = $fungsi->getNamaBulanShort(substr($jst->bln_thn, 4, 2));
$tahun_tag = substr($jst->bln_thn, 0, 4);
$tagihan = $fungsi->rupiah($jst->tagihan);
$admin_bank = $fungsi->rupiah($jst->admin_bank);
$total_tagihan = $fungsi->rupiah($jst->total_tagihan);
$contentTmp ='';
$pesan_lunas = "PDAM MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBAYARAN YANG SAH";
$pesan = "TERIMA KASIH ATAS KEPERCAYAAN ANDA MEMBAYAR DI LOKET KAMI";


if ($printType == 'DOTMATRIX') {
	$content .= ' 0x1B@0x0F ' . $fungsi->spasi(43, '') . $config->namaBank() . $fungsi->spasi(62, '') . $config->namaAplikasi() . '
0x0 SEGI PELUNASAN ' . $fungsi->spasi(40, '') . '0x1B!0x24 ' . $judul_struk . '
0x0A TANGGAL BAYAR  : ' . $waktu . '
0x0 NO. PELANGGAN   : ' . $fungsi->spasi(27, $idpel) . 'NO. PELANGGAN      : ' . $idpel . '
0x0 NAMA            : ' . $fungsi->spasi(27,$nama).    'NAMA               : ' .$nama .'
0x0 BULAN / THN     : ' . $fungsi->spasi(27,$nama_bulan . ' / ' . $tahun_tag).    'BULAN / THN        : ' .$nama_bulan . ' / ' . $tahun_tag;
	if ((int) $denda > 0) {
		$content .= '
	0x0 DENDA : Rp. ' . $fungsi->spasi(27,$denda).    'DENDA               : ' .$denda ;
	}
	$content .= '
0x0 TAGIHAN         : Rp. ' . $fungsi->spasi(23,$tagihan).    'TAGIHAN            : ' .$tagihan .'
0x0 ADMIN BANK      : Rp. ' . $fungsi->spasi(23,$admin_bank).    'ADMIN BANK         : ' .$admin_bank .'
0x0 TOTAL           : Rp. ' . $fungsi->spasi(23,$total_tagihan).    'TOTAl              : ' .$total_tagihan .'
0x0
0x0A                                         ' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '
0x0 ' . $tambahan . '
0x0';
} elseif ($printType == 'BLUETOOTH') {
	$content .= ""
			. "\n" . $config->namaAplikasi()
			. "\n"
			. "\n================================"
			. "\nSTRUK PEMBAYARAN PDAM "
			. "\n--------------------------------"
			. "\nNO PEL  : " . $idpel
			. "\nNAMA     : " . $nama
			. "\nALAMAT   : " . $alamat
			. "\nPERIODE  : " . $nama_bulan . "/" . $tahun_tag
			. "\nGOLONGAN : " . $golongan
			. "\n"
			. "\nDENDA    : Rp." . $denda
			. "\nADMIN    : Rp." . $admin_bank
			. "\nRP TAG   : Rp." . $tagihan
			. "\nREFF     : " . $ref
			. "\nTOTAL    : Rp." . $total_tagihan
			. "\n================================"
			. "\n\n\n";
} elseif ($printType == 'PDF') {
	$isi_tbl = '';
	$isi_tbl = "NO PEl>: $idpel^3> ^3<"
			. "NAMA>: $nama^3> ^3<"
			. "ALAMAT>: $alamat^3> ^3<"
			. "PERIODE>: $nama_bulan / $tahun_tag ^3> ^3<"
			. "GOLONGAN>: $lembar BULAN^3> ^3<"
			. "DENDA>: Rp. >$denda^1^right> > ^3<"
			. "TAGIHAN>: Rp. >$tagihan^1^right> > ^3<"
			. "$pesan_lunas^7^center<"
			. "ADMIN BANK>: Rp. >$admin_bank^1^right> > ^3<"
			. "TOTAL BAYAR>: Rp. >$total_tagihan^1^right> > ^3<";
	$isi_tbl .= "$pesan^7^center<";

	$contentTmp .= $fungsiHtml->strukHeader($config->namaBank(), $config->namaAplikasi(), $judul_struk)
			. $fungsiHtml->jsonToHtmlFull($isi_tbl);

	$contentTmp .= '<tr><td colspan="7" style="font-size: 8px">' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '</td></tr>';
	$contentTmp .= $fungsiHtml->strukFooter();
	$content = $contentTmp;
} else {
	//image
	$content = json_encode($arr_trx);
}