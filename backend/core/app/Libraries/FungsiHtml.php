<?php

namespace Libraries;

use Resources;

class FungsiHtml {

    public static function jsonToHtml($jdata) {
        $table = '';
        $jml_array = count($jdata);
        for ($i = 0; $i < $jml_array; $i++) {
            $table =  $table.'<tr><td>' . $jdata[$i][0] . '</td><td> : ' . $jdata[$i][1] . '</td></tr>';
        }
        return '<table>'.$table.'</table>';
    }
    
    public static function jsonToHtmlFull($jdata) {
//        $jdataX = "IDPEL>123456123456^2^right> >BL/TH>JAN 2017<"
//                . "IDPEL>123456123456^2> >BL/TH>JAN 2017";
        $arbar = explode("<", $jdata);
        $content = '';
        foreach ($arbar as $baris){
            $content .= '<tr>';
            $arkol = explode('>', $baris);
            foreach ($arkol as $kolom){
                $arisi = explode('^', $kolom);
                $colspan = '';
                $style = '';
                if(isset($arisi[1])){
                    $colspan = ' colspan='.$arisi[1];
                }
                if(isset($arisi[2])){
                    $style = ' style="text-align:'.$arisi[2].'"';
                }
                $content .= '<td'.$colspan.$style.'>'.$arisi[0].'</td>';
            }
            $content .= '</tr>';
        }
        return $content;
    }
    
    public static function strukHeader($nama_bank,$nama_aplikasi,$judul) {
        return '<page orientation="P" backcolor="#FFFFFF" style="font: arial;font-size:12px">
            <div style="background-image: url(bg.jpg);background-repeat: no-repeat;background-position: center;">
            <table border="0" cellpadding="0" cellspacing="1">
            <tbody>
            <tr>
                    <td style="font-size: 11px;width: 100px">' . $nama_bank . '</td>
                    <td style="width: 20px"></td>
                    <td style="width: 100px"></td>
                    <td style="width: 200px"></td>
                    <td style="width: 100px"></td>
                    <td style="width: 20px"></td>
                    <td style="font-size: 11px;text-align: right">' . $nama_aplikasi . '</td>
            </tr>
            <tr><td colspan="7" style="text-align: center;font-size: 14px">'.$judul.'</td></tr>
            <tr><td colspan="7"></td></tr>';
    }
    
    public static function strukFooter() {
        return '</tbody></table></div></page>';
    }
    
    public static function documentHeader() {
        return '<page orientation="P" backcolor="#FFFFFF" style="font: arial;font-size:12px">'
        . '<table border="1" cellpadding="0" cellspacing="0"><tbody>';
    }
    
    public static function documentFooter() {
        return '</tbody></table></page>';
    }

}
