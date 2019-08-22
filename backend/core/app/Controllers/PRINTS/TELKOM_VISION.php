<?php

$fungsi = new Libraries\Fungsi();
$config = new Libraries\Konfigurasi();
$fungsiHtml = new Libraries\FungsiHtml();

$jst = json_decode($arr_trx->struk);
$penanda = $arr_trx->cetak == 1 ? 'CA' : 'CU';
$waktu = $arr_trx->waktu;
$noid = $arr_trx->noid;
$judul_struk = 'STRUK PEMBAYARAN TAGIHAN T.VISION';
$idpel = $jst->idpel;
$nama = $jst->nama;
$lembar = $jst->lembar;
$ref = $jst->reff;
$vsn = $jst->vsn;
$contentTmp = '';

$bulan_tahun = $jst->bulan_tahun;
$tagihan = $fungsi->rupiah($jst->tagihan);
$admin_bank = $fungsi->rupiah($jst->admin_bank);
$total_tagihan = $fungsi->rupiah($jst->total_tagihan);

$pesan_lunas = "TELKOM MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBAYARAN YANG SAH";
$pesan = "TERIMA KASIH ATAS KEPERCAYAAN ANDA MEMBAYAR DI LOKET KAMI";

if ($printType == 'DOTMATRIX') {
	$content = ' 0x1B@0x0F ' . $fungsi->spasi(43, '') . $config->namaBank() . $fungsi->spasi(62, '') . $config->namaAplikasi() . '
0x0 SEGI PELUNASAN ' . $fungsi->spasi(40, '') . '0x1B!0x24 ' . $judul_struk . '
0x1B@0x0F LAYANAN    : ' . $fungsi->spasi(27, $arr_trx->product_detail) . 'LAYANAN     : ' . $arr_trx->product_detail . '
0x0 ID PEL     : ' . $fungsi->spasi(27, $idpel) . 'ID PEL      : ' . $idpel . '
0x0 NAMA PLG   : ' . $fungsi->spasi(27, $nama) . 'NAMA PLG    : ' . $nama . '
0x0 BLN TAGIHAN: ' . $fungsi->spasi(27, $bulan_tahun) . 'BLN TAGIHAN : ' . $bulan_tahun . '
0x0 BILL REFF  : ' . $fungsi->spasi(27, $ref) . 'BILL REFF   : ' . $ref . '
0x0 RP TAG     : RP. ' . $fungsi->spasiKanan(12, $tagihan) . $fungsi->spasi(11, '') . 'RP TAG      : RP. ' . $fungsi->spasiKanan(14, $tagihan) . '
0x0              ' . $fungsi->spasi(27, ' ') . $pesan_lunas . '
0x0 ADMIN      : RP. ' . $fungsi->spasiKanan(12, $admin_bank) . $fungsi->spasi(11, '') . 'ADMIN BANK  : RP. ' . $fungsi->spasiKanan(14, $admin_bank) . '
0x0 TOTAL BAYAR: RP. ' . $fungsi->spasiKanan(12, $total_tagihan) . $fungsi->spasi(11, '') . 'TOTAL BAYAR : RP. ' . $fungsi->spasiKanan(14, $total_tagihan) . '
0x0 
0x0              ' . $fungsi->spasi(27, ' ') . $pesan . '
0x0A                                         ' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '
0x0 ' . $tambahan . '
0x0';
} elseif ($printType == 'BLUETOOTH') {
	$content = ""
			. "\n" . $config->namaAplikasi()
			. "\n"
			. "\n================================"
			. "\n".$judul_struk
			. "\n--------------------------------"
			. "\nIDPEL   : " . $idpel
			. "\nNAMA    : " . $nama
			. "\nPERIODE : " . $bulan_tahun
			. "\nTAGIHAN : Rp." . $tagihan
			. "\n"
			. "\n TELKOM menyatakan ini sebagai"
			. "\n   bukti pembayaran yang sah"
			. "\n  Mohon disimpan, Terimakasih"
			. "\n================================"
			. "\n\n\n";
} elseif ($printType == 'PDF') {
	$isi_tbl = '';
	$isi_tbl = "LAYANAN>: $arr_trx->product_detail^3> ^3<"
			. "NO TELEPON>: $idpel^3> ^3<"
			. "NAMA PLG>: $nama^3> ^3<"
			. "BLN TAGIHAN>: $bulan_tahun^3> ^3<"
			. "BILL REFF>: $ref^3> ^3<"
			. "RP TAG>: Rp. >$tagihan^1^right> > ^3<"
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