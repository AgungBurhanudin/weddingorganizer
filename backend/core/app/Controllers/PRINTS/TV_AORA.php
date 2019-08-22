<?php

$fungsi = new Libraries\Fungsi();
$config = new Libraries\Konfigurasi();
$fungsiHtml = new Libraries\FungsiHtml();

$jst = json_decode($arr_trx->struk);
$penanda = $arr_trx->cetak == 1 ? 'CA' : 'CU';
$waktu = $arr_trx->waktu;
$noid = $arr_trx->noid;
$judul_struk = 'STRUK PEMBAYARAN AORA TV';
$idpel = $jst->idpel;
$ref = $jst->reff;
$vsn = $jst->vsn;
$nama = $jst->nama;
$contentTmp = '';
$namaPaket = $jst->namaPaket;
$kodetv = $jst->kodeTv;

$admin_bank = $fungsi->rupiah($jst->admin_bank);
$tagihan = $fungsi->rupiah($jst->tagihan);
$total_tagihan = $fungsi->rupiah($jst->total_tagihan);

$pesan_lunas = $config->namaAplikasi() . " TV AORA MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBELIAN YANG SAH";
$pesan = "TERIMA KASIH ATAS KEPERCAYAAN ANDA MEMBAYAR DI LOKET KAMI";

if ($printType == 'DOTMATRIX') {
	$content .= ' 0x1B@0x0F ' . $fungsi->spasi(43, '') . $config->namaBank() . $fungsi->spasi(62, '') . $config->namaAplikasi() . '
0x0 SEGI PELUNASAN ' . $fungsi->spasi(40, '') . '0x1B!0x24 ' . $judul_struk . '
0x0A TANGGAL BAYAR : ' . $fungsi->spasi(20, $waktu) . '
0x0 NO. PELANGGAN  : ' . $fungsi->spasi(30, $idpel) . 'NO.REFF   : ' . $ref . '
0x0 NAMA           : ' . $fungsi->spasi(20, $nama) . '
0x0 TAGIHAN        : Rp. ' . $tagihan . '
0x0 ADMIN BANK     : Rp. ' . $admin_bank . '
0x0 TOTAL          : Rp. ' . $total_tagihan . '
0x0
0x0
0x0
0x0          ' . $fungsi->spasi(35, '') . 'TERIMA KASIH ATAS KEPERCAYAAN ANDA MEMBAYAR DI LOKET KAMI
0x0              ' . $fungsi->spasi(35, '') . 'SIMPANLAH STRUK INI SEBAGAI BUKTI PEMBAYARAN ANDA
0x0
0x0A                                         ' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '
0x0';
} elseif ($printType == 'BLUETOOTH') {
	$content .= ""
			. "\n" . $config->namaAplikasi()
			. "\n"
			. "\n================================"
			. "\n" . $judul_struk
			. "\n--------------------------------"
			. "\nIDPEL      : " . $idpel
			. "\nNAMA       : " . $nama
			. "\nPAKET      : " . $namaPaket
			. "\nTAGIHAN    : Rp." . $tagihan
			. "\nADMIN BANK : Rp." . $total_tagihan
			. "\nTOTAL BAYAR: Rp." . $total_tagihan
			. "\nNO REF     : " . $ref
			. "\nKODE AORA  : " . $kodetv
			. "\n================================"
			. "\n\n\n";
} elseif ($printType == 'PDF') {
	$isi_tbl = '';
	$isi_tbl = "IDPEL>: $idpel^3> ^3<"
			. "NAMA>: $nama^3> ^3<"
			. "PAKET>: $namaPaket^3> ^3<"
			. "KODE AORA>: $kodetv^3> ^3<"
			. "$pesan_lunas^7^center<"
			. "TAGIHAN>: Rp.  >$tagihan^1^right> ^3<"
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