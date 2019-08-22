<?php

//INQUIRY

$figt = new Libraries\FungsiIgt;

if (strlen($idpel) > 12 || strlen($idpel) < 11 || is_numeric($idpel) == FALSE) {
    $response_code = "0014";
} else {
    $url_request = $figt->igtUrl() . 'get/inquiry/json/' . $figt->igtNoid() . '/' . $figt->igtToken() . '/PLN/POSTPAID/' . $idpel . '/' . $admin_bank . '/' . $reff;
    if ($environment == 'prod') {
        $response = $figt->getCurlResult($url_request);
        $wLog->writeLog($interface, 'INQUIRY_PLN_POSTPAID', $response);
    } else {
        $simul = new Libraries\Simulator();
        $response = $simul->plnpostpaid('inq');
    }
    $arr = json_decode($response);
    if (isset($arr->response_code)) {
        $response_code = $arr->response_code;
        if ($response_code == '0000') {
            $billPeriod = "";
            $total = 0;
            foreach ($arr->ori->postpaidBillInfos as $billInfo) {
                if ($billPeriod != "") {
                    $billPeriod = $billPeriod . ",";
                }
                $total = $total + (int) $billInfo->totalElectricityBill + (int) $billInfo->penaltyFee;
                $billPeriod = $billPeriod . $fungsi->getNamaBulanShort(substr($billInfo->billPeriod, 4, 2)) . substr($billInfo->billPeriod, 0, 4);
            }
            $tagihan = $total;
            $admin_bank = $admin_bank * $arr->ori->billStatus;
            $total_tagihan = $tagihan + $admin_bank;
            $lembar = $arr->ori->billStatus;
            $idpel_name = trim($arr->ori->subscriberName);
            $daya = $arr->ori->powerConsumingCategory + 0;

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