<?php

$fungsi = new Libraries\Fungsi();
$fungsiHtml = new Libraries\FungsiHtml();
$db = new Models\Databases();
$id_group = $arr_jenis[1];
$content = '';
$tagihan = 0;
$admin_bank = 0;
$total_tagihan = 0;
$lembar = 0;

$sql_cek = "select id,idpel,idpel_name,tagihan,admin_bank,total_tagihan,bulan,date(last_update) as waktu from tbl_group_kolektif_detail where id_group = $id_group;";
$arr = $db->multipleRow($sql_cek);

if (isset($arr[0]->id)) {
    if ($printType == 'DOTMATRIX') {
        $contentTmp = ' 0x1B@0x0F ' . $fungsi->spasi(4, 'NO') . '|'
                . $fungsi->spasi(18, 'IDPEL') . '|'
                . $fungsi->spasi(30, 'NAMA PELANGGAN') . '|'
                . $fungsi->spasi(14, '   TAGIHAN') . '|'
                . $fungsi->spasi(14, '  ADMIN BANK') . '|'
                . $fungsi->spasi(14, ' TOTAL TAGIHAN') . '|'
                . $fungsi->spasiKanan(8, 'LEMBAR ') . '|'
                . $fungsi->spasiKanan(10, 'WAKTU   ') . '
';
        ;
        $contentTmp .= $fungsi->spasi(4, '----') . '|'
                . $fungsi->spasi(18, '------------------') . '|'
                . $fungsi->spasi(30, '------------------------------') . '|'
                . $fungsi->spasi(14, '--------------') . '|'
                . $fungsi->spasi(14, '--------------') . '|'
                . $fungsi->spasi(14, '--------------') . '|'
                . $fungsi->spasiKanan(8, '--------') . '|'
                . $fungsi->spasiKanan(10, '----------') . '
';
        ;
        $i = 1;
        //no idpel idpel_name tagihan admin_bank total tagihan lembar
        foreach ($arr as $isi) {
            $tagihan += $isi->tagihan;
            $admin_bank += $isi->admin_bank;
            $total_tagihan += $isi->total_tagihan;
            $lembar += $isi->bulan;
            $contentTmp .= $fungsi->spasi(4, $i) . '|'
                    . $fungsi->spasi(18, $isi->idpel) . '|'
                    . $fungsi->spasi(30, $isi->idpel_name) . '|'
                    . $fungsi->spasiKanan(14, $fungsi->rupiah($isi->tagihan)) . '|'
                    . $fungsi->spasiKanan(14, $fungsi->rupiah($isi->admin_bank)) . '|'
                    . $fungsi->spasiKanan(14, $fungsi->rupiah($isi->total_tagihan)) . '|'
                    . $fungsi->spasi(8, '   ' . $isi->bulan) . '|'
                    . $fungsi->spasiKanan(10, $isi->waktu) . '
';
            $i++;
        }
        $contentTmp .= $fungsi->spasi(4, '----') . '|'
                . $fungsi->spasi(18, '------------------') . '|'
                . $fungsi->spasi(30, '------------------------------') . '|'
                . $fungsi->spasi(14, '--------------') . '|'
                . $fungsi->spasi(14, '--------------') . '|'
                . $fungsi->spasi(14, '--------------') . '|'
                . $fungsi->spasiKanan(8, '--------') . '|'
                . $fungsi->spasiKanan(10, '----------') . '
';
        $contentTmp .= $fungsi->spasi(4, '----') . '|'
                . $fungsi->spasi(18, '------------------') . '|'
                . $fungsi->spasi(30, '------------------------------') . '|'
                . $fungsi->spasiKanan(14, $fungsi->rupiah($tagihan)) . '|'
                . $fungsi->spasiKanan(14, $fungsi->rupiah($admin_bank)) . '|'
                . $fungsi->spasiKanan(14, $fungsi->rupiah($total_tagihan)) . '|'
                . $fungsi->spasi(8, '   ' . $lembar) . '|'
                . $fungsi->spasiKanan(10, '----------') . '
';
        $content = $contentTmp . '
0x0 
0x0 ';
    } elseif ($printType == 'PDF') {
        $jumlah_baris = count($arr);
        $isi_tbl = "NO> IDPEL >_NAMA PELANGGAN_>_TAGIHAN_>_ADMIN BANK_>_TOTAL TAGIHAN_>LEMBAR>__WAKTU__<";
        $i = 1;
        //no idpel idpel_name tagihan admin_bank total tagihan lembar
        foreach ($arr as $isi) {
            $tagihan += $isi->tagihan;
            $admin_bank += $isi->admin_bank;
            $total_tagihan += $isi->total_tagihan;
            $lembar += $isi->bulan;

            $isi_tbl .= "$i>$isi->idpel>" . substr($isi->idpel_name, 0, 30) . ">" . $fungsi->rupiah($isi->tagihan) . "^1^right>" . $fungsi->rupiah($isi->admin_bank) . "^1^right>" . $fungsi->rupiah($isi->total_tagihan) . "^1^right>$isi->bulan^1^center>$isi->waktu<";
            $i++;
        }
        $isi_tbl .= " > > >" . $fungsi->rupiah($tagihan) . "^1^right>" . $fungsi->rupiah($admin_bank) . "^1^right>" . $fungsi->rupiah($total_tagihan) . "^1^right>" . $lembar . "^1^center>";
        $contentTmp = $fungsiHtml->documentHeader() . $fungsiHtml->jsonToHtmlFull($isi_tbl);

        $contentTmp .= $fungsiHtml->documentFooter();
        $content = $contentTmp;
    }
} else {
    //tidak ada datanya
}
