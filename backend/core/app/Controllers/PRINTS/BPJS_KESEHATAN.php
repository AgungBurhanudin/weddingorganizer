<?php

$fungsi = new Libraries\Fungsi();
$config = new Libraries\Konfigurasi();
$fungsiHtml = new Libraries\FungsiHtml();

$jst = json_decode($arr_trx->struk);
$penanda = $arr_trx->cetak == 1 ? 'CA' : 'CU';
$waktu = $arr_trx->waktu;
$noid = $arr_trx->noid;
$judul_struk = 'STRUK BPJS KESEHATAN';
$idpel = $jst->idpel;
$ref = $jst->reff;
$vsn = $jst->vsn;
$tagihan = $fungsi->rupiah($jst->tagihan);
$admin_bank = $fungsi->rupiah($jst->admin_bank);
$total_tagihan = $fungsi->rupiah($jst->total_tagihan);
$contentTmp = '';


$pesan_lunas = "BPJS MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBAYARAN YANG SAH";
$pesan = "Rincian Tagihan dapat diakses pada www.bpjs-kesehatan.go.id";

if ($printType == 'DOTMATRIX') {
	$content .= ' 0x1B@0x0F ' . $fungsi->spasi(43, '') . $config->namaBank() . $fungsi->spasi(62, '') . $config->namaAplikasi() . '
0x0 SEGI PELUNASAN ' . $fungsi->spasi(40, '') . '0x1B!0x24 ' . $judul_struk . '
0x1B@0x0F NO REFF    : ' . $fungsi->spasi(25, $ref) . '  NO REFF     : ' . $ref . '
0x0 WAKTU      : ' . $fungsi->spasi(27, $waktu) . 'WAKTU       : ' . $waktu . '
0x0 NO. VA     : ' . $fungsi->spasi(27, $idpel) . 'NO. VA      : ' . $idpel . '
0x0 NAMA       : ' . $fungsi->spasi(27, $nama) . 'NAMA        : ' . $nama . '
0x0 PERIODE    : ' . $fungsi->spasi(27, $lembar . ' BULAN') . 'PERIODE     : ' . $lembar . ' BULAN 
0x0 JUMLAH     : RP. ' . $fungsi->spasiKanan(12, $tagihan) . $fungsi->spasi(11, '') . 'JUMLAH      : RP. ' . $fungsi->spasiKanan(14, $tagihan) . '
0x0              ' . $fungsi->spasi(27, ' ') . $pesan_lunas . '
0x0 ADMIN BANK : RP. ' . $fungsi->spasiKanan(12, $admin_bank) . $fungsi->spasi(11, '') . 'ADMIN BANK  : RP. ' . $fungsi->spasiKanan(14, $admin_bank) . '
0x0 TOTAL BAYAR: RP. ' . $fungsi->spasiKanan(12, $total_tagihan) . $fungsi->spasi(11, '') . 'TOTAL BAYAR : RP. ' . $fungsi->spasiKanan(14, $total_tagihan) . '
0x0 
0x0              ' . $fungsi->spasi(27, ' ') . $pesan . '
0x0A                                         ' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '
0x0 ' . $tambahan . '
0x0';
} elseif ($printType == 'BLUETOOTH') {
	$content = ""
			. "\n	   " . $config->namaAplikasi()
			. "\n"
			. "\n================================"
			. "\n     ".$judul_struk
			. "\n--------------------------------"
			. "\nNO. REFF: " . $ref
			. "\nWAKTU   : " . $waktu
			. "\nNO. VA  : " . $idpel
			. "\nNAMA    : " . $nama
			. "\nPERIODE : " . $lembar . " BULAN"
			. "\nJUMLAH  : Rp." . $tagihan
			. "\nBPJS KESEHATAN MENYATAKAN"
			. "\nSTRUK INI SEBAGAI BUKTI"
			. "\nPEMBAYARAN YANG SAH"
			. "\nADMIN   : Rp." . $admin_bank
			. "\nT. BAYAR: Rp." . $total_tagihan
			. "\nRincian tagihan dapat diakses"
			. "\npada www.bpjs-kesehatan.go.id"
			. "\n================================"
			. "\n\n\n";
} elseif ($printType == 'PDF') { 
	$isi_tbl = '';
	$isi_tbl = "NO REFF>: $idpel^3> ^3<"
			. "WAKTU>: $nama^3> ^3<"
			. "NOMOR VA>: $idpel^3> ^3<"
			. "NAMA>: $nama^3> ^3<"
			. "PERIODE>: $lembar BULAN^3> ^3<"
			. "JUMLAH>: Rp. >$tagihan^1^right> > ^3<"
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