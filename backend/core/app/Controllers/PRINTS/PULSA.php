<?php

$fungsi = new Libraries\Fungsi();
$config = new Libraries\Konfigurasi();
$fungsiHtml = new Libraries\FungsiHtml();

$jst = json_decode($arr_trx->struk);
$penanda = $arr_trx->cetak == 1 ? 'CA' : 'CU';
$waktu = $arr_trx->waktu;
$noid = $arr_trx->noid;
$judul_struk = 'STRUK PEMBELIAN PULSA';
$idpel = $jst->idpel;
$ref = $jst->reff;
$vsn = $jst->vsn;
$contentTmp = '';

$tagihan = $fungsi->rupiah($jst->tagihan);
$admin_bank = $fungsi->rupiah($jst->admin_bank);
$total_tagihan = $fungsi->rupiah($jst->total_tagihan);

$pesan_lunas = $config->namaAplikasi() . " MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBELIAN YANG SAH";
$pesan = "TERIMA KASIH ATAS KEPERCAYAAN ANDA MEMBAYAR DI LOKET KAMI";

if ($printType == 'DOTMATRIX') {
    $content = ' 0x1B@0x0F ' . $fungsi->spasi(43, '') . $config->namaBank() . $fungsi->spasi(58, '') . $config->namaAplikasi() . '
0x0 SEGI PEMBELIAN ' . $fungsi->spasi(40, '') . '0x1B!0x24 ' . $judul_struk . '
0x1B@0x0F PRODUK     : ' . $fungsi->spasi(27, $arr_trx->product_detail) . 'PRODUK      : ' . $arr_trx->product_detail . '
0x0 WAKTU      : ' . $fungsi->spasi(27, $waktu) . 'WAKTU       : ' . $waktu . '
0x0 NOMOR HP   : ' . $fungsi->spasi(27, $idpel) . 'NOMOR HP    : ' . $idpel . '
0x0 VSN        : ' . $fungsi->spasi(27, $vsn) . 'VSN         : ' . $vsn . '
0x0 NO REFF    : ' . $fungsi->spasi(27, $ref) . 'NO REFF     : ' . $ref . '
0x0 
0x0              ' . $fungsi->spasi(27, ' ') . $pesan_lunas . '
0x0 
0x0 
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
            . "\n" . $judul_struk
            . "\n--------------------------------"
            . "\nPRODUK : " . $arr_trx->product_detail
            . "\nWAKTU  : " . $waktu
            . "\nNOHP   : " . $idpel
            . "\nVSN    : " . $vsn
            . "\nNOREFF : " . $ref
            . "\n================================"
            . "\n\n\n";
} elseif ($printType == 'PDF') {
    $isi_tbl = '';
    $isi_tbl = "PRODUK>: " . $arr_trx->product_detail . "^3> ^3<"
            . "WAKTU>: $waktu^3> ^3<"
            . "NOMOR HP>: $idpel^3> ^3<"
            . "VSN>: $vsn^3> ^3<"
            . "NO REFF>: $ref^3> ^3<"
            . "$pesan_lunas^7^center<";

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