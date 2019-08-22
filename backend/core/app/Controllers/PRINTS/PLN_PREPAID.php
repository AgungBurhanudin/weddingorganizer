<?php

$fungsi = new Libraries\Fungsi();
$config = new Libraries\Konfigurasi();
$fungsiHtml = new Libraries\FungsiHtml();

$judul_struk = 'STRUK PEMBELIAN LISTRIK PRABAYAR';

$arr_trx->struk;
$jst = json_decode($arr_trx->struk);
$penanda = $arr_trx->cetak == 1 ? 'CA' : 'CU';
$waktu = $arr_trx->waktu;
$noid = $arr_trx->noid;

$nomor_meter = $jst->nomor_meter;
$idpel = $jst->idpel;
$nama = $jst->nama;
$segmen = $jst->segmen;
$daya = $jst->daya;
$stroom = $fungsi->rupiah($jst->stroom);
$kwh = $jst->kwh;
$vsn = $jst->vsn;
$ref = $jst->ref;
$angsuran = $fungsi->rupiah($jst->angsuran);
$meterai = $fungsi->rupiah($jst->meterai);
$ppn = $fungsi->rupiah($jst->ppn);
$ppj = $fungsi->rupiah($jst->ppj);
$admin = $fungsi->rupiah($jst->admin);
$total = $fungsi->rupiah($jst->total);
$info = $jst->info;
$arrInfo = explode("\n", wordwrap($info, 35, "\n"));
$token = $jst->token;
$tok1 = substr($token, 0, 4);
$tok2 = substr($token, 4, 4);
$tok3 = substr($token, 8, 4);
$tok4 = substr($token, 12, 4);
$tok5 = substr($token, 16, 4);
$new_token = $tok1 . " " . $tok2 . " " . $tok3 . " " . $tok4 . " " . $tok5;


if ($printType == 'DOTMATRIX') {
    $content = ' 0x1B@0x0F ' . $fungsi->spasi(43, '') . $config->namaBank() . $fungsi->spasi(62, '') . $config->namaAplikasi() . '
0x0 SEGI PELUNASAN' . $fungsi->spasi(40, '') . ' 0x1B!0x24 ' . $judul_struk . '
0x1B@0x0F NOMET      : ' . $fungsi->spasi(27, $nomor_meter) . 'NO METER   : ' . $fungsi->spasi(54, $nomor_meter) . 'MATERAI  : Rp.' . $fungsi->spasiKanan(14, $meterai) . '
0x0 IDPEL      : ' . $fungsi->spasi(27, $idpel) . 'IDPEL      : ' . $fungsi->spasi(54, $idpel) . 'PPN      : Rp.' . $fungsi->spasiKanan(14, $ppn) . '
0x0 NAMA       : ' . $fungsi->spasi(27, substr($nama, 0, 19)) . 'NAMA       : ' . $fungsi->spasi(54, $nama) . 'PPJ      : Rp.' . $fungsi->spasiKanan(14, $ppj) . '
0x0 TARIF      : ' . $fungsi->spasi(27, $segmen . '/' . $daya . 'VA') . 'TARIF/DAYA : ' . $fungsi->spasi(54, $segmen . '/' . $daya . 'VA') . 'ANGSURAN : Rp.' . $fungsi->spasiKanan(14, $angsuran) . '
0x0 STROOM     : Rp.' . $fungsi->spasiKanan(12, $stroom) . $fungsi->spasi(12, '') . 'NO REF     : ' . $fungsi->spasi(54, $ref) . 'RPSTROOM : Rp.' . $fungsi->spasiKanan(14, $stroom) . '
0x0 JMLKWH     : ' . $fungsi->spasi(27, $kwh) . 'RP BAYAR   : Rp. ' . $fungsi->spasi(50, $total) . 'JML KWH  : ' . $fungsi->spasiKanan(17, $kwh) . '
0x0 ADMIN      : Rp.' . $fungsi->spasiKanan(12, $admin) . $fungsi->spasi(79, '') . 'ADM BANK : Rp.' . $fungsi->spasiKanan(14, $admin) . '
0x0 BAYAR      : Rp.' . $fungsi->spasiKanan(12, $total) . $fungsi->spasi(12, '') . 'STROOM / TOKEN : 0x1B!0x24 ' . $new_token . '
0x1B@0x0F REF        : ' . substr($ref, 0, 16) . '
0x0              ' . substr($ref, 16, 16) . '                           ' . $info . '
0x0 
0x0A                                        ' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '
0x0 ' . $tambahan . '
0x0';
} elseif ($printType == 'BLUETOOTH') {
    $content = ""
            . "\n" . $config->namaAplikasi()
            . "\n"
            . "\n================================"
            . "\n" . $judul_struk
            . "\n--------------------------------"
            . "\nNOMER  : " . $nomor_meter
            . "\nIDPEL  : " . $idpel
            . "\nNAMA   : " . $nama
            . "\nTARIF  : " . $segmen . "/" . $daya . "VA"
            . "\nNO REF : " . substr($ref, 0, 16)
            . "\n         " . substr($ref, 16, 16)
            . "\nBAYAR  : RP " . $total
            . "\nMTERAI : RP " . $meterai
            . "\nPPN    : RP " . $ppn
            . "\nPPJ    : RP " . $ppj
            . "\nANGSRN : RP " . $angsuran
            . "\nSTROOM : RP " . $stroom
            . "\nJMLKWH : " . $kwh
            . "\n"
            . "\nTOKEN  : "
            . "\n" . $new_token
            . "\n"
            . "\nADMIN  : RP " . $admin
            . "\n================================"
            . "\n"
            . "\n" . str_replace('Informasi', 'Info', $arrInfo[0])
            . "\n" . $arrInfo[1]
            . "\n\n" . $waktu . '/' . $vsn
            . "\n"
            . "\n"
            . "\n";
} elseif ($printType == 'PDF') {

    $isi_tbl = '';
    $isi_tbl = "NO METER>: $nomor_meter^2> >METERAI>: Rp. >$meterai^1^right<"
            . "IDPEL>: $idpel^2> >PPN>: Rp. >$ppn^1^right<"
            . "NAMA>: $nama^3>PPJ>: Rp. >$ppj^1^right<"
            . "TARIF / DAYA>: $segmen/$daya VA^2> >ANGSURAN>: Rp. >$angsuran^1^right<"
            . "NO REF>: $ref^3>RP STROOM / TOKEN>: Rp. >$stroom^1^right<"
            . "RP BAYAR>: Rp. >$total> >JML KWH>: >$kwh^1^right<"
            . " ^3> >ADMIN BANK>: Rp. >$admin^1^right<";

    $contentTmp = '';
    $contentTmp .= $fungsiHtml->strukHeader($config->namaBank(), $config->namaAplikasi(), $judul_struk)
            . $fungsiHtml->jsonToHtmlFull($isi_tbl);
    $contentTmp .= '<tr><td colspan="7" style="text-align: left;font-size: 18px;font: bold">STROOM/TOKEN : ' . $new_token . '</td></tr>'
            . '<tr><td colspan=7></td></tr>';
    $contentTmp .= '<tr><td colspan="7" style="text-align: center;">' . str_replace("|", "<br>", $info) . '</td></tr>'
            . '<tr><td colspan=7></td></tr>';
    $contentTmp .= '<tr><td colspan="7" style="font-size: 8px">' . $noid . '/' . $waktu . '/' . $vsn . '/' . $penanda . '</td></tr>';
    $contentTmp .= $fungsiHtml->strukFooter();

    $content = $contentTmp;
} else {
    //image
    $content = json_encode($arr_trx);
}