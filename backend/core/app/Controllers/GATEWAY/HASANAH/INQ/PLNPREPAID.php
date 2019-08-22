<?php

//INQUIRY

$fhasan = new Libraries\FungsiHasanah;

if (strlen($idpel) > 12 || strlen($idpel) < 11 || is_numeric($idpel) == FALSE) {
    $response_code = "0014";
} else {

    if ($environment == 'prod') {
        $url_request = $fhasan->hasanahUrl() . 'get/inquiry/json/' . $fhasan->hasanahNoid() . '/' . $fhasan->hasanahToken() . '/PLN/PREPAID/' . $idpel . '/' . $admin_bank . '/' . $reff;
        $response_asli = $fhasan->getCurlResult($url_request);
        
        libxml_use_internal_errors(true);

        $response_xml = simplexml_load_string($response_asli);
        
        if ($response_xml === false) {
            $response_code = '0099';
        }

        $response = json_encode($response_xml);
//        die($response);
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
            $idpel_name = trim($arr->content->subscriberName);
            $daya = $arr->content->powerConsumingCategory + 0;

            $jh = array();
            $jh[0][0] = 'PEMBELIAN';
            $jh[0][1] = $product . ' ' . $product_detail;
            $jh[1][0] = 'IDPEL';
            $jh[1][1] = $arr->content->subscriberId;
            $jh[2][0] = 'NOMOR METER';
            $jh[2][1] = $arr->content->meterSerialNumber;
            $jh[3][0] = 'NAMA';
            $jh[3][1] = $idpel_name;
            $jh[4][0] = 'DAYA';
            $jh[4][1] = $daya . ' VA';
            $jh[5][0] = 'RP TAG';
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