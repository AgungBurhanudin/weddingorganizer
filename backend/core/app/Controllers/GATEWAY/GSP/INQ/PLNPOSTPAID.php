<?php

//INQUIRY

$fgsp = new Libraries\FungsiGsp;

if (strlen($idpel) > 12 || strlen($idpel) < 11 || is_numeric($idpel) == FALSE) {
    $response_code = "0014";
} else {
    
    if ($environment == 'prod') {
        $url_request = $fgsp->gspUrl() . 'SapulindoPLNISOSwitch/postpaid_inquiry.jsp';
        $param = '{"traceID": "'.$reff.'","merchantCode": "6025","userID": "42344",'
                . '"idpel": "'.$idpel.'","admin": "'.$admin_bank.'"}';
        $response_asli = $fgsp->getCurlResult($url_request,$param);
        
//        die($response);
        $response = str_replace("'", "`", $response_asli);
        $arr = json_decode($response);
        $wLog->writeLog($interface, 'INQUIRY_PLN_POSTPAID', $response);
    } else {
        $simul = new Libraries\SimulatorHpay();
        $response = $simul->plnpostpaid('inq');
        $arr = json_decode($response);
    }
    
    if (isset($arr->responseCode)) {
        $response_code = $arr->responseCode;
        if ($response_code == '0000') {
            $log_biller = $response;
            $billPeriod = "";
            $total = 0;
            $lembar = $arr->billStatus;
            
            foreach ($arr->detail as $billInfo) {
                if ($billPeriod != "") {
                    $billPeriod = $billPeriod . ",";
                }
                $total = $total + (int) $billInfo->totalElectricityBill + (int) $billInfo->penaltyFee + (int) $billInfo->valueAddedTax;
                $billPeriod = $billPeriod . $fungsi->getNamaBulanShort(substr($billInfo->billPeriod, 4, 2)) . substr($billInfo->billPeriod, 2, 2);
            }
            
            $tagihan = $arr->amount;
            $admin_bank = $admin_bank * $arr->billStatus;
            $total_tagihan = $tagihan + $admin_bank;
            $idpel_name = trim($arr->subscriberName);
            $daya = $arr->powerConsumingCategory + 0;

            $jh = array();
            $jh[0][0] = 'PEMBAYARAN';
            $jh[0][1] = $product . ' ' . $product_detail;
            $jh[1][0] = 'IDPEL';
            $jh[1][1] = $idpel;
            $jh[2][0] = 'NAMA';
            $jh[2][1] = str_replace("`", "'",$idpel_name);
            $jh[3][0] = 'TOTAL TAGIHAN';
            $jh[3][1] = $lembar . ' BULAN';
            $jh[4][0] = 'BL/TH';
            $jh[4][1] = $billPeriod;
            $jh[5][0] = 'RP TAG PLN';
            $jh[5][1] = $fungsi->rupiah($tagihan);
            $jh[6][0] = 'ADMIN BANK';
            $jh[6][1] = $fungsi->rupiah($admin_bank);
            $jh[7][0] = 'TOTAL BAYAR';
            $jh[7][1] = $fungsi->rupiah($total_tagihan);
            $response_html = $fHtml->jsonToHtml($jh);

        }
    } else {
        $response_code = '0099';
    }
}