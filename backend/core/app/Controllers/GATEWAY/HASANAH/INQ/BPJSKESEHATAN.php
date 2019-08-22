<?php

//INQUIRY

$fhpay = new Libraries\FungsiHpay;
if(substr($idpel, 0,3) == '000'){
    $idpel = '88888'.substr($idpel,2,11);
}
if (strlen($idpel) != 16) {
    $response_code = "0014";
} else {
    if ($environment == 'prod') {
        $reqxml = '<hpay>'
                . '<channel>H2H</channel>'
                . '<hpayProduct>'
                . '<productCode>000200020013</productCode>'
                . '</hpayProduct>'
                . '<hpayTrxType>INQUIRY</hpayTrxType>'
                . '<account>' . $fhpay->hpayNoid() . '</account>'
                . '<channelRefNum>' . $reff . '</channelRefNum>'
                . '<content xsi:type="bpjsKeluargaXMLInqRequest" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'
                . '<nomorPelanggan>'.$idpel.'</nomorPelanggan>'
                . '<jmlBulan>1</jmlBulan>'
                . '</content>'
                . '</hpay>';

        $response_asli = $fhpay->hpayCurl($fhpay->hpayUrl(), $reqxml, $fhpay->hpayHeader($reqxml));
        libxml_use_internal_errors(true);

        $response_xml = simplexml_load_string($response_asli);
        if ($response_xml === false) {
            $response_code = '0099';
        }

        $response = json_encode($response_xml);
//        die($response);
        $arr = json_decode($response);
        $wLog->writeLog($interface, 'INQUIRY_BPJS', $idpel . ' >> ' . $response_asli);
    } else {
        $response = $fhpay->bpjskesehatan('inq');
        $arr = json_decode($response);
    }

    if (isset($arr->responseCode)) {
        $response_code = '00' . str_replace('00', '', $arr->responseCode);
        if ($response_code == '00') {
            $response_code = '0000';
            $log_biller = $response;

            $tagihan = $arr->content->totalAmount;
            $lembar = $arr->content->jmlBulan + 0;
            $admin_bank = $admin_bank * $lembar;
            $total_tagihan = $tagihan + $admin_bank;
            $idpel_name = strtoupper(trim($arr->content->billsInfo[0]->namaPelanggan));
            $jumlah_peserta = $arr->content->totalAnggota;
            
            $jh = array();
            $jh[0][0] = 'PEMBAYARAN';
            $jh[0][1] = $product . ' ' . $product_detail;
            $jh[1][0] = 'NOMOR PESERTA';
            $jh[1][1] = $idpel;
            $jh[2][0] = 'NAMA PESERTA';
            $jh[2][1] = $idpel_name;
            $jh[3][0] = 'JUMLAH PESERTA';
            $jh[3][1] = $jumlah_peserta;
            $jh[4][0] = 'JUMLAH BULAN';
            $jh[4][1] = $lembar . ' Bulan';
            $jh[5][0] = 'SISA SEBELUMNYA';
            $jh[5][1] = 0;
            $jh[6][0] = 'TAGIHAN';
            $jh[6][1] = $fungsi->rupiah($tagihan);
            $jh[7][0] = 'ADMIN BANK';
            $jh[7][1] = $fungsi->rupiah($admin_bank);
            $jh[8][0] = 'TOTAL TAGIHAN';
            $jh[8][1] = $fungsi->rupiah($total_tagihan);
            $response_html = $fHtml->jsonToHtml($jh);
        }
    } else {
        $response_code = '0099';
    }
}

