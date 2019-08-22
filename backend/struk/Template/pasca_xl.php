<?php

$xplor = $obj->paylog;

$idpel = (string)$xplor->content->noHp;
//$noref = (string)$xplor->content->kodeXL;

$lembar = (int)$xplor->content->jmlTagihan;
$nama = (string)$xplor->content->namaPelanggan;

$totalTag = 0;
if($lembar > 1){
	for($i=0; $i<$lembar; $i++)
    {
        $tag = (string)$obj_xml->content->nilaiTagihan;
		$totalTag = $totalTag + $tag;

        $tgltok = $tglCommon; // ini ngambil dari mana ya ??? "201".substr($billRef,0,1)."/".substr($billRef,1,2)."/".substr($billRef,3,2);
        $jamtok = $jamCommon; // ini ngambil dari mana ya ??? (string)$obj_xml->content->billRef;
	}
	$totalTag = $totalTag + $admin;
} else {
	$tag = (string)$xplor->content->nilaiTagihan;
	$totalTag = $tag + $admin;

	//$noref = (string)$xplor->content->billRef;
	//$billRef = (string)$xplor->content->billRef;

	//$tgltok = $tglCommon; // ini ngambil dari mana ya ??? "201".substr($billRef,0,1)."/".substr($billRef,1,2)."/".substr($billRef,3,2);
    	//$jamtok = $jamCommon; // ini ngambil dari mana ya ??? (string)$obj_xml->content->billRef;
}

imagestring($im, 3, (imagesx($im) - 7.5 * strlen("XPLOR")) / 1.9, 110, "XPLOR", $black);
//imagestring($im, 2, 18, 130, "TANGGAL     : ", $black); imagestring($im, 2, strlen("JML TAGIHAN :")*6+25, 130, $tgltok, $black);
imagestring($im, 2, 18, 145, "NO KARTU    : ", $black); imagestring($im, 2, strlen("JML TAGIHAN :")*6+25, 145, substr($idpel, 0,strlen($idpel)-4) . "####", $black);
imagestring($im, 2, 18, 160, "NAMA PLG    : ", $black); imagestring($im, 2, strlen("JML TAGIHAN :")*6+25, 160, $nama, $black);
imagestring($im, 2, 18, 175, "JML TAGIHAN : ", $black); imagestring($im, 2, strlen("JML TAGIHAN :")*6+25, 175, "Rp.".rupiah($totalTag), $black);

/* if ($printType == PRINT_INK) {
    $content .= '
    <style>
        div {background-image: url(bg.jpg); background-repeat: no-repeat; background-position: center;}
        .first, .third {width: 355px;}
        .second {width: 30px;}
        .first1 {width: 100px;}
        .third1 {width: 215px;}
        .third2 {width: 85px;}
        .title {text-align: center; font-weight: bold;}
        .bold {font-weight: bold;}
        .border_bottom {border-bottom: 1px solid black;}
        .border_right {border-right: 1px solid black;}
        .border_left {border-left: 1px solid black;}
        .right {text-align: right;}
        .center {text-align: center;}
    </style>';
    if (!$isMulti) $content .= '<page orientation="P" backcolor="#FFFFFF" style="font: arial;font-size:12px">';

    for($i=0; $i<$lembar; $i++)
    {
        $tag = (string)$obj_xml->content->nilaiTagihan;

        if ($i + 1 == $lembar) $tag = $tag + $admin;

        $tgltok = $tglCommon; // ini ngambil dari mana ya ??? "201".substr($billRef,0,1)."/".substr($billRef,1,2)."/".substr($billRef,3,2);
        $jamtok = $jamCommon; // ini ngambil dari mana ya ??? (string)$obj_xml->content->billRef;

        $content .= '
        <div>
        <table border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td class="first">BNI Syariah</td>
                    <td class="second">&nbsp;</td>
                    <td class="third right">Hasanah Payment</td>
                </tr>
                <tr>
                    <td class="title" colspan="3">PEMBAYARAN XL XPLOR</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table border="0" style="margin:auto;">
                            <tr>
                                <td class="first1 center">TANGGAL</td>
                                <td class="first1 center">JAM</td>
                            </tr>
                            <tr>
                                <td class="center">' . $tgltok . '</td>
                                <td class="center">' . $jamtok . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0">
                            <tbody>
                                <tr>
                                    <td class="first1">NO KARTU</td>
                                    <td>:</td>
                                    <td class="third1">' . $idpel . '</td>
                                </tr>
                                <tr>
                                    <td>NO RESI</td>
                                    <td>:</td>
                                    <td>' . $noref . '</td>
                                </tr>
                                <tr>
                                    <td>NO PONSEL</td>
                                    <td>:</td>
                                    <td> 0' . $idpel . '</td>
                                </tr>
                                <tr>
                                    <td>NAMA PELANGGAN</td>
                                    <td>:</td>
                                    <td> 0' . $nama . '</td>
                                </tr>
                                <tr>
                                    <td class="bold">JML TAGIHAN</td>
                                    <td class="bold">:</td>
                                    <td class="bold">Rp. ' . Libraries\Common\Func::rupiah($tag) . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td></td>
                    <td class="center" valign="middle">
                        NPWP PT XL Axiata: 01.345.276.8-091.000 <br /><br />
                        grhaXL <br />
                        Jl DR. Ide Anak Agung Gde Agung Lot E4-7 No.1 <br />
                        Jakarta 12950 – Indonesia <br />
                        TAX ALREADY INCLUDED <br /><br />
                        UNTUK KELUHAN HUBUNGI 133 <br />
                        RESI INI ADALAH BUKTI PEMBELIAN YANG SAH <br />
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" class="center">TRANSAKSI BERHASIL</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </tbody>
        </table>

        </div>';
    if (!$isMulti) $content .= '</page>';
    }
}
else if ($printType == PRINT_DOT)
{
    $content = '
0x1B@0x1B!0x01
SEGI PEMBAYARAN                        STRUK PEMBAYARAN TAGIHAN XL XPLOR
0x0A TANGGAL BAYAR  : '.Libraries\Common\Func::spasi(20, $tglBayar).'
0x0 NO. PONSEL     : '.Libraries\Common\Func::spasi(20, $idpel).'IDTRX   : '.$row->id_log.'
0x0 NAMA           : '.Libraries\Common\Func::spasi(20, $nama).'
0x0 TAGIHAN        : Rp. '.Libraries\Common\Func::rupiah($tagihan).'
0x0 ADMIN BANK     : Rp. '.Libraries\Common\Func::rupiah($admin).'
0x0 TOTAL          : Rp. '.Libraries\Common\Func::rupiah($tagihan + $admin).'
0x0
0x0
0x0
0x0                                 grhaXL
0x0                 Jl DR. Ide Anak Agung Gde Agung Lot E4-7 No.1
0x0          TERIMA KASIH ATAS KEPERCAYAAN ANDA MEMBAYAR DI LOKET KAMI
0x0              SIMPANLAH STRUK INI SEBAGAI BUKTI PEMBAYARAN ANDA
0x0
0x0';
} */
