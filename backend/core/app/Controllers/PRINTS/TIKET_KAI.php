<?php

$fungsi = new Libraries\Fungsi();
$config = new Libraries\Konfigurasi();
$fungsiHtml = new Libraries\FungsiHtml();

$jst = json_decode($arr_trx->struk);
$penanda = $arr_trx->cetak == 1 ? 'CA' : 'CU';
$waktu = (string) $jst->hari_bulan;
$waktu = substr($waktu, 6, 2) . " " . $fungsi->getNamaBulanShort(substr($waktu, 4, 2)) . " " . substr($waktu, 0, 4);
$jams = (string) $jst->jamBerangkat;
$jams = substr($jams, 0, 2) . ":" . substr($jams, 2, 2);
$noid = $arr_trx->noid;
$vsn = $jst->vsn;
$judul_struk = 'STRUK PEMBAYARAN KERETA API';
$idpel = $jst->idpel;
$nama = $jst->nama;
$train_name = $jst->train;
$train_no = $jst->train_no;
$ref = $jst->reff;
$seat = (string) $jst->seats;
$tripInfo = $jst->tripInfo[0];
$from = (string) $tripInfo->from;
$to = (string) $tripInfo->to;
$jmlPenumpang = (int) $tripInfo->jmlPenumpang;
$kelas = (string) $tripInfo->kelas;

$tagihan = $fungsi->rupiah($jst->tagihan);
$admin_bank = $fungsi->rupiah($jst->admin_bank);
$total_bayar = $fungsi->rupiah($jst->total_tagihan);

$contentTmp = '';
$pesan_lunas = "TUKARKAN STRUK DENGAN TIKET DI STASIUN ONLINE PALING LAMBAT	 1 JAM SEBELUM KEBERANGKATAN";
$pesan = "INFO LEBIH LANJUT  HUBUNGI CONTACT  CENTER KAI 121";


if ($printType == 'DOTMATRIX') {
	$content .= ' 0x1B@0x0F ' . $fungsi->spasi(43, '') . $config->namaBank() . $fungsi->spasi(62, '') . $config->namaAplikasi() . '
0x0 SEGI PELUNASAN ' . $fungsi->spasi(40, '') . '0x1B!0x24 ' . $judul_struk . '
0x0 KODE BOOKING   :' . $fungsi->spasi(20, $vsn) . 'NAMA              : ' . $nama . '
0x0 KERETA API     :' . $fungsi->spasi(20, $train_name) . 'JUMLAH PENUMPANG  : ' . $jmlPenumpang . ' DEWASA
0x0 TGL BERANGKAT  :' . $fungsi->spasi(20, $waktu) . 'NOMOR KURSI       : ' . $seat . '
0x0 STASIUN ASAL   :' . $fungsi->spasi(20, $from) . '
0x0 STASIUN TUJUAN :' . $fungsi->spasi(20, $to) . '
0x0 KELAS          :' . $fungsi->spasi(20, $kelas) . '
0x0 HARGA TIKET    :RP. ' . $tagihan . '
0x0 ADM            :RP. ' . $admin_bank . '
0x0 TOTAL BAYAR    :RP. ' . $total_bayar . '
0x0
0x0 ' . $fungsi->spasi(35, '') . 'TUKARKAN STRUK INI DENGAN TIKET DI STASIUN ONLINE PALING LAMBAT 1 JAM SEBELUM KEBERANGKATAN
0x0 ' . $fungsi->spasi(35, '') . 'INFORMASI LEBIH LANJUT DAPAT DILIHAT DI WWW.KERETA-API.CO.ID / CONTACT CENTER 121
0x0
0x0A                                         ' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '
0x0 ' . $tambahan . '
0x0';
} elseif ($printType == 'BLUETOOTH') {
	$content .= ""
			. "\n" . $config->namaAplikasi()
			. "\n"
			. "\n================================"
			. "\nSTRUK PEMBAYARAN TIKET KAI"
			. "\n--------------------------------"
			. "\nK.BOOKING   : " . $vsn
			. "\nNO BAYAR    : " . $idpel
			. "\nNAMA        : " . $nama
			. "\nNO KERETA   : " . $train_no
			. "\nKERETA      : " . $train_name
			. "\nNO KURSI    : " . $seat
			. "\nTGL/JAM     : " . $waktu . '/' . $jams
			. "\nRUTE        : " . $from . ' - ' . $to
			. "\n"
			. "\nNO REFF     :" . $ref
			. "\nJML BAYAR   : Rp." . $tagihan
			. "\nADMIN       : Rp." . $admin_bank
			. "\nTOTAL BAYAR : Rp." . $total_bayar
			. "\n================================"
			. "\n\n\n";
} elseif ($printType == 'PDF') {
	$isi_tbl = '';
	$isi_tbl = "K.BOOKING>: >$vsn^3> ^3<"
			. "NO BAYAR>: >$idpel^3> ^3<"
			. "NAMA>: >$nama^3> ^3<"
			. "NO KERETA>: >$train_no ^3> ^3<"
			. "NAMA KERETA>: >$train_name^3> ^3<"
			. "NO KURSI>: >$seat^1^right> > ^3<"
			. "TGL/JAM>: >$waktu/$jams^1^right> > ^3<"
			. "RUTE>: >$from-$to^1^right> > ^3<"
			. "NO REFF>: >$ref^1^right> > ^3<"
			. "$pesan_lunas^7^center<"
			. "JML BAYAR>: Rp. >$tagihan^1^right> > ^3<"
			. "ADMIN BANK>: Rp. >$admin_bank^1^right> > ^3<"
			. "TOTAL BAYAR>: Rp. >$total_bayar^1^right> > ^3<";
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