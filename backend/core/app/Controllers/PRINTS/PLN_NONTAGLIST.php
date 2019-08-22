<?php

$fungsi = new Libraries\Fungsi();
$config = new Libraries\Konfigurasi();
$fungsiHtml = new Libraries\FungsiHtml();

$jst = json_decode($arr_trx->struk);
$penanda = $arr_trx->cetak == 1 ? 'CA' : 'CU';
$waktu = $arr_trx->waktu;
$noid = $arr_trx->noid;
$judul_struk = 'STRUK NON TAGIHAN LISTRIK';

$jenis = $jst->jenis;
$no_reg = $jst->no_reg;
$tgl_reg = date("d-m-Y", strtotime($jst->tgl_reg));
$nama = $jst->nama;
$idpel = $jst->idpel;
$admin = $fungsi->rupiah($jst->admin);
$total = $fungsi->rupiah($jst->total);
$total_bayar = $fungsi->rupiah($jst->admin + $jst->total);
$noref = $jst->ref;
$vsn = $jst->vsn;
$contentTmp = '';

$pesan_lunas = "PLN MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBAYARAN YANG SAH";
$pesan = "RINCIAN TAGIHAN DAPAT DIAKSES DI WWW.PLN.CO.ID ATAU PLN TERDEKAT";

if ($printType == 'DOTMATRIX') {
    $content = ' 0x1B@0x0F ' . $fungsi->spasi(43, '') . $config->namaBank() . $fungsi->spasi(62, '') . $config->namaAplikasi() . '
0x0 SEGI PELUNASAN ' . $fungsi->spasi(40, '') . '0x1B!0x24 ' . $judul_struk . '
0x1B@0x0F JENIS      : ' . $fungsi->spasi(27, $jenis) . 'JENIS          : ' . $jenis . '
0x0 NO REG     : ' . $fungsi->spasi(27, $no_reg) . 'NO REGISTRASI  : ' . $no_reg . '
0x0 TGL REG    : ' . $fungsi->spasi(27, $tgl_reg) . 'TGL REGISTRASI : ' . $tgl_reg . '
0x0 NAMA       : ' . $fungsi->spasi(27, $nama) . 'NAMA           : ' . $nama . '
0x0 IDPEL      : ' . $fungsi->spasi(27, $idpel) . 'IDPEL          : ' . $idpel . '
0x0 ADMIN      : RP. ' . $fungsi->spasiKanan(12, $admin) . $fungsi->spasi(11, '') . 'NO REF         : ' . $noref . '
0x0 TOTAL      : RP. ' . $fungsi->spasiKanan(12, $total) . $fungsi->spasi(11, '') . 'ADMIN BANK     : RP. ' . $fungsi->spasiKanan(14, $admin) . '
0x0 NO REF     : ' . $fungsi->spasi(27, substr($noref, 0, 16)) . 'TOTAL BAYAR    : RP. ' . $fungsi->spasiKanan(14, $total) . '
0x0              ' . $fungsi->spasi(27, substr($noref, 16, 16)) . '
0x0 
0x0              ' . $fungsi->spasi(27, ' ') . $pesan_lunas . '
0x0A                                         ' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '
0x0 ' . $tambahan . '
0x0';
} elseif ($printType == 'BLUETOOTH') {
    $content .= ""
            . "\n"
            . "\n================================"
            . "\n" . $judul_struk
            . "\n--------------------------------"
            . "\nTRANSAKSI : " . $jenis
            . "\nNO REG  : " . $noref
            . "\n"
            . "\nTGL REG : " . $tgl_reg
            . "\nNAMA : " . $nama
            . "\nID PEL : " . $idpel
            . "\nBIAYA PLN : Rp." . $total
            . "\nNO REF   : " . $noref
            . "\n"
            . "\nADMIN : Rp." . $admin
            . "\nTOTAL : Rp." . $total_bayar
            . "\n================================"
            . "\n\n" . $noid . "/" . $tgl_reg . "/" . $vsn . "/" . $penanda
            . "\n\n\n";
} elseif ($printType == 'PDF') {
    $isi_tbl = '';
    $isi_tbl = "JENIS>: $jenis^3> ^3<"
            . "NO REGISTRASI>: $no_reg^3> ^3<"
            . "TGL REGISTRASI>: $tgl_reg^3> ^3<"
            . "NAMA>: >$nama^3> ^3<"
            . "IDPEL>: $idpel^3> ^3<"
            . "NOREF>: $noref^3> ^3<"
            . "$pesan_lunas^7^center<"
            . "ADMIN BANK>: Rp. >$admin^1^right> > ^3<"
            . "TOTAL BAYAR>: Rp. >$total^1^right> > ^3<";
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