<?php

//INQUIRY

$fgsp = new Libraries\FungsiGsp;

if (strlen($idpel) > 12 || strlen($idpel) < 11 || is_numeric($idpel) == FALSE) {
    $response_code = "0014";
} else {

    if ($environment == 'prod') {
        $url_request = $fgsp->gspUrl() . 'SapulindoPLNISOSwitch/prepaid_inquiry.jsp';
        $param = '{"traceID": "'.$reff.'","merchantCode": "6025","userID": "42344",'
                . '"idpel": "'.$idpel.'","admin": "'.$admin_bank.'"}';
        $response_asli = $fgsp->getCurlResult($url_request,$param);
        
//        die($response_asli);
        $response = str_replace("'", "`", $response_asli);
        $arr = json_decode($response);
        
        $wLog->writeLog($interface, 'INQUIRY_PLN_PREPAID', $response_asli);
    } else {
        $simul = new Libraries\SimulatorHpay();
        $response = $simul->plnprepaid('inq');
        $arr = json_decode($response);
    }

    if (isset($arr->responseCode)) {
        $response_code = '00' . str_replace('00', '', $arr->responseCode);
        if ($response_code == '00') {
            $response_code = '0000';
            $log_biller = $response;
            $tagihan = $nominal;
            $total_tagihan = $tagihan + $admin_bank;
            $lembar = 1;
            $idpel_name = trim($arr->subscriberName);
            $daya = $arr->powerConsumingCategory + 0;

            $jh = array();
            $jh[0][0] = 'PEMBELIAN';
            $jh[0][1] = $product . ' ' . $product_detail;
            $jh[1][0] = 'NOMOR METER';
            $jh[1][1] = $arr->meterSerialNumber;
            $jh[2][0] = 'NAMA';
            $jh[2][1] = str_replace("`", "'",$idpel_name);
            $jh[3][0] = 'TARIF/DAYA';
            $jh[3][1] = $daya . ' VA';
            $jh[4][0] = 'RP TAG';
            $jh[4][1] = $fungsi->rupiah($tagihan);
            $jh[5][0] = 'ADMIN BANK';
            $jh[5][1] = $fungsi->rupiah($admin_bank);
            $jh[6][0] = 'TOTAL BAYAR';
            $jh[6][1] = $fungsi->rupiah($total_tagihan);
            $response_html = $fHtml->jsonToHtml($jh);
        }
    } else {
        $response_code = '0099';
    }
}