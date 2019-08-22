<?php

//INQUIRY

$fhasan = new Libraries\FungsiHasanah;

if (strlen($idpel) > 12 || strlen($idpel) < 11 || is_numeric($idpel) == FALSE) {
    $response_code = "0014";
} else {
    
    if ($environment == 'prod') {
        $url_request = $fhasan->hasanahUrl() . 'get/inquiry/json/' . $fhasan->hasanahNoid() . '/' . $fhasan->hasanahToken() . '/PLN/POSTPAID/' . $idpel . '/' . $admin_bank . '/' . $reff;
        $response_asli = $fhasan->getCurlResult($url_request);
        
        libxml_use_internal_errors(true);

        $response_xml = simplexml_load_string($response_asli);
        
        if ($response_xml === false) {
            $response_code = '0099';
        }

        $response = json_encode($response_xml);
//        die($response);
        $arr = json_decode($response);
        $wLog->writeLog($interface, 'INQUIRY_PLN_POSTPAID', $response_asli);
    } else {
        $simul = new Libraries\SimulatorHpay();
        $response = $simul->plnpostpaid('inq');
        $arr = json_decode($response);
    }
    
    if (isset($arr->responseCode)) {
        $response_code = '00' . str_replace('00', '', $arr->responseCode);
        if ($response_code == '00') {
            $response_code = '0000';
            $log_biller = $response;
            $billPeriod = "";
            $total = 0;
            $lembar = $arr->content->billStatus;
            if($lembar == 1){
                $total = $total + (int) $arr->content->postpaidBillInfos->totalElectricityBill + (int) $arr->content->postpaidBillInfos->penaltyFee + (int) $arr->content->postpaidBillInfos->valueAddedTax;
                $billPeriod = $fungsi->getNamaBulanShort(substr($arr->content->postpaidBillInfos->billPeriod, 4, 2)) . substr($arr->content->postpaidBillInfos->billPeriod, 0, 4);
            }else{
            foreach ($arr->content->postpaidBillInfos as $billInfo) {
                if ($billPeriod != "") {
                    $billPeriod = $billPeriod . ",";
                }
                $total = $total + (int) $billInfo->totalElectricityBill + (int) $billInfo->penaltyFee + (int) $billInfo->valueAddedTax;
                $billPeriod = $billPeriod . $fungsi->getNamaBulanShort(substr($billInfo->billPeriod, 4, 2)) . substr($billInfo->billPeriod, 0, 4);
            }
            }
            $tagihan = $arr->content->totalAmount;
            $admin_bank = $admin_bank * $arr->content->billStatus;
            $total_tagihan = $tagihan + $admin_bank;
            $idpel_name = trim($arr->content->subscriberName);
            $daya = $arr->content->powerConsumingCategory + 0;

            $jh = array();
            $jh[0][0] = 'PEMBAYARAN';
            $jh[0][1] = $product . ' ' . $product_detail;
            $jh[1][0] = 'IDPEL';
            $jh[1][1] = $idpel;
            $jh[2][0] = 'NAMA';
            $jh[2][1] = $idpel_name;
            $jh[3][0] = 'DAYA';
            $jh[3][1] = $daya . ' VA';
            $jh[4][0] = 'TOTAL TAGIHAN';
            $jh[4][1] = $lembar . ' BULAN';
            $jh[5][0] = 'BL/THN';
            $jh[5][1] = $billPeriod;
            $jh[6][0] = 'RP TAG';
            $jh[6][1] = $fungsi->rupiah($tagihan);
            $jh[7][0] = 'ADMIN BANK';
            $jh[7][1] = $fungsi->rupiah($admin_bank);
            $jh[8][0] = 'TOTAL BAYAR';
            $jh[8][1] = $fungsi->rupiah($total_tagihan);
            $response_html = $fHtml->jsonToHtml($jh);

        }
    } else {
        $response_code = '0099';
    }
}