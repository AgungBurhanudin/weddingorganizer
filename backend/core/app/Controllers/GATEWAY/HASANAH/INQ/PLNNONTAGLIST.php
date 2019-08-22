<?php

//INQUIRY

$fhpay = new Libraries\FungsiHpay;

if (strlen($idpel) != 13 || is_numeric($idpel) == FALSE) {
    $response_code = "0014";
} else {
    if ($environment == 'prod') {
        $reqxml = '<?xml version="1.0" encoding="UTF-8"?>'
                . '<hpay>'
                . '<channel>H2H</channel><hpayProduct>'
                . '<productCode>000400040002</productCode>'
                . '<admin>'. $admin_bank .'</admin>'
                . '</hpayProduct>'
                . '<hpayTrxType>INQUIRY</hpayTrxType>'
                . '<account>' . $fhpay->hpayNoid() . '</account>'
                . '<content xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '
                . 'xsi:type="gspXMLInqRequestNontaglist">'
                . '<registrationNumber>'. $idpel .'</registrationNumber>'
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
        
        $wLog->writeLog($interface, 'INQUIRY_PLN_NONTAGLIST', $response_asli);
    } else {
        $response = $fhpay->plnnontaglist('inq');
        $arr = json_decode($response);
    }

    if (isset($arr->responseCode)) {
        $response_code = '00' . str_replace('00', '', $arr->responseCode);
        if ($response_code == '00') {
            $response_code = '0000';
            $log_biller = $response;
            $tagihan = $arr->content->totalAmount;
            $total_tagihan = $tagihan + $admin_bank;
            $lembar = 1;
            $idpel_name = $arr->content->subscriberName;
            $jenis_transaksi = $arr->content->transactionName;

            $jh = array();
            $jh[0][0] = 'PEMBAYARAN' ;$jh[0][1] = $product.' '.$product_detail;
            $jh[1][0] = 'NO REGISTRASI';$jh[1][1] = $idpel;
            $jh[2][0] = 'TRANSAKSI'  ;$jh[2][1] = $jenis_transaksi;
            $jh[3][0] = 'NAMA'  ;$jh[3][1] = $idpel_name;
            $jh[4][0] = 'RP TAG'  ;$jh[4][1] = $tagihan;
            $jh[5][0] = 'ADMIN BANK'  ;$jh[5][1] = $admin_bank;
            $jh[6][0] = 'TOTAL BAYAR'  ;$jh[6][1] = $total_tagihan;
            $response_html = $fHtml->jsonToHtml($jh);
        }
    } else {
        $response_code = '0099';
    }
}