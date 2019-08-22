<?php

$fungsi = new Libraries\Fungsi();
$config = new Libraries\Konfigurasi();
$fungsiHtml = new Libraries\FungsiHtml();

$judul_struk = 'STRUK PEMBAYARAN TAGIHAN LISTRIK';
$jst = json_decode($arr_trx->struk);
$penanda = $arr_trx->cetak == 1 ? 'CA' : 'CU';
$waktu = $arr_trx->waktu;
$noid = $arr_trx->noid;

$idpel = $jst->idpel;
$nama = $jst->nama;
$segmen = $jst->segmen;
$daya = $jst->daya;
$lembar = $jst->lembar;
$detail = $jst->detail;
$ref = $jst->reff;
$info = $jst->info;
$vsn = $jst->vsn;

$pesan_lunas = 'PLN MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBAYARAN YANG SAH';

$x = 1;


if ($printType == 'DOTMATRIX') {
    $contentTmp = '';
    foreach ($jst->detail as $billInfo) {
        $nama_bulan = $fungsi->getNamaBulanShort(substr($billInfo->billPeriod, 4, 2));
        $tahun_tag = substr($billInfo->billPeriod, 0, 4);
        $standmeter1 = $billInfo->standmeter1;
        $standmeter2 = $billInfo->standmeter2;
        $tagihan = $fungsi->rupiah($billInfo->tagihan);
        $admin_bank = $fungsi->rupiah($billInfo->admin_bank);
        $total = $fungsi->rupiah($billInfo->tagihan + $billInfo->admin_bank);
        if ($tambah == 1) {
            $tambahan = '
0x0';
        } else {
            $tambahan = '';
        }
        $tambah = $tambah * -1;

        if ($lembar - $x == 0) {
            $pesan = "                   TERIMA KASIH";
        } else {
            $sisatunggakan = $lembar - $x;
            $pesan = "ANDA MASIH MEMILIKI SISA TUNGGAKAN $sisatunggakan BULAN";
        }

        $contentTmp .= ' 0x1B@0x0F ' . $fungsi->spasi(43, '') . $config->namaBank() . $fungsi->spasi(62, '') . $config->namaAplikasi() . '
0x0 SEGI PELUNASAN ' . $fungsi->spasi(40, '') . '0x1B!0x24 ' . $judul_struk . '
0x1B@0x0F IDPEL      : ' . $fungsi->spasi(27, $idpel) . 'IDPEL       : ' . $fungsi->spasi(49, $idpel) . 'BL/TH         : ' . $fungsi->spasi(16, $nama_bulan . $tahun_tag) . '
0x0 NAMA       : ' . $fungsi->spasi(27, $nama) . 'NAMA        : ' . $fungsi->spasi(49, $nama) . 'STAND METER   : ' . $standmeter1 . '-' . $standmeter2 . '
0x0 TARIF      : ' . $fungsi->spasi(27, $segmen . '/' . $daya . 'VA') . 'TARIF/DAYA  : ' . $fungsi->spasi(20, $segmen . '/' . $daya . 'VA') . '
0x0 BL/TH      : ' . $fungsi->spasi(27, $nama_bulan . $tahun_tag) . 'RP TAG PLN  : RP. ' . $fungsi->spasiKanan(14, $tagihan) . '
0x0 STAND      : ' . $fungsi->spasi(27, $standmeter1 . '-' . $standmeter2) . 'NO REF      : ' . $ref . '
0x0 TAGPLN     : RP. ' . $fungsi->spasiKanan(12, $tagihan) . $fungsi->spasi(25, '') . $pesan_lunas . '
0x0 ADMIN      : RP. ' . $fungsi->spasiKanan(12, $admin_bank) . $fungsi->spasi(11, '') . 'ADMIN BANK  : RP. ' . $fungsi->spasiKanan(14, $admin_bank) . '
0x0 TOTAL      : RP. ' . $fungsi->spasiKanan(12, $total) . $fungsi->spasi(11, '') . 'TOTAL BAYAR : RP. ' . $fungsi->spasiKanan(14, $total) . '
0x0 REF        : ' . substr($ref, 0, 16) . '
0x0              ' . $fungsi->spasi(40, substr($ref, 16, 16)) . $pesan . '
0x0 
0x0A                                         ' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '
0x0 ' . $tambahan . '
0x0';

        $x++;
    }
    $content = $contentTmp;
} elseif ($printType == 'BLUETOOTH') {
    $content = '';
    foreach ($jst->detail as $billInfo) {
        $nama_bulan = $fungsi->getNamaBulanShort(substr($billInfo->billPeriod, 4, 2));
        $tahun_tag = substr($billInfo->billPeriod, 0, 4);
        $standmeter1 = $billInfo->standmeter1;
        $standmeter2 = $billInfo->standmeter2;
        $tagihan = $fungsi->rupiah($billInfo->tagihan);
        $admin_bank = $fungsi->rupiah($billInfo->admin_bank);
        $total = $fungsi->rupiah($billInfo->tagihan + $billInfo->admin_bank);

        if ($lembar - $x == 0) {
            $pesan = "         TERIMA KASIH";
        } else {
            $sisatunggakan = $lembar - $x;
            $pesan = "ANDA MASIH MEMILIKI SISA TUNGGAKAN $sisatunggakan BULAN";
        }
        $x++;
        
        $content .= ""
                . "\n" . $config->namaAplikasi()
                . "\n"
                . "\n================================"
                . "\n" . $judul_struk
                . "\n--------------------------------"
                . "\nIDPEL : " . $idpel
                . "\nNAMA  : " . $nama
                . "\nTARIF : " . $segmen . "/" . $daya . "VA"
                . "\nBL/TH : " . $nama_bulan . "" . $tahun_tag
                . "\nSTAND : " . $standmeter1 . '-' . $standmeter2
                . "\nRPTAG : RP " . $tagihan
                . "\nREF   : " . $ref
                . "\n PLN MENYATAKAN STRUK INI SEBAGAI"
                . "\n     BUKTI PEMBAYARAN YANG SAH"
                . "\nADMIN : RP " . $admin_bank
                . "\nTOTAL : RP " . $total
                . "\n================================"
                . "\n".  wordwrap($pesan,35)
                . "\n"
                . "\n"
                . "\n";
    }
} elseif ($printType == 'PDF') {
    $contentTmp = '';
    foreach ($jst->detail as $billInfo) {

        $nama_bulan = $fungsi->getNamaBulanShort(substr($billInfo->billPeriod, 4, 2));
        $tahun_tag = substr($billInfo->billPeriod, 0, 4);
        $standmeter1 = $billInfo->standmeter1;
        $standmeter2 = $billInfo->standmeter2;
        $tagihan = $fungsi->rupiah($billInfo->tagihan);
        $admin_bank = $fungsi->rupiah($billInfo->admin_bank);
        $total = $fungsi->rupiah($billInfo->tagihan + $billInfo->admin_bank);

        if ($lembar - $x == 0) {
            $pesan = "TERIMA KASIH^7^center";
        } else {
            $sisatunggakan = $lembar - $x;
            $pesan = "ANDA MASIH MEMILIKI SISA TUNGGAKAN $sisatunggakan BULAN^7^center";
        }

        $isi_tbl = '';
        $isi_tbl = "IDPEL>: $idpel^2> >BL/TH>: $nama_bulan $tahun_tag^2<"
                . "NAMA>: $nama^3>STAND METER>: $standmeter1 - $standmeter2^2<"
                . "TARIF / DAYA>: $segmen/$daya VA^2> > ^3<"
                . "RP TAG PLN>: Rp. >$tagihan> > ^3<"
                . "NO REF>: $ref^3> ^3<"
                . " ^7<"
                . "PLN menyatakan struk ini sebagai bukti pembayaran yang sah^7^center<"
                . "ADMIN BANK>: Rp. >$admin_bank^1^right> > ^3<"
                . "TOTAL BAYAR>: Rp. >$total^1^right> > ^3<";

        $isi_tbl .= $pesan;
        $isi_tbl.= str_replace("|", "<br>", $info) . "^7^center<";

        $contentTmp .= $fungsiHtml->strukHeader($config->namaBank(), $config->namaAplikasi(), $judul_struk)
                . $fungsiHtml->jsonToHtmlFull($isi_tbl);

        $contentTmp .= '<tr><td colspan="7" style="font-size: 8px">' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '</td></tr>';
        $contentTmp .= $fungsiHtml->strukFooter();
        $x++;
    }
    $content = $contentTmp;
} else {
    //image
    $content = json_encode($arr_trx);
}