<?php

//PAYMENT
//di dalam struk wajib ada vsn

$fhasan = new Libraries\FungsiHasanah;
if ($environment == 'prod') {
    $req = json_decode($dtrx->log_biller);
    $billInfos = '';
    $detail_tagihan = array();
    $admin_bank = $dtrx->admin_bank / $dtrx->lembar;
    if ($dtrx->lembar == 1) {
        $detail_tag = array(
            'billPeriod' => $req->content->postpaidBillInfos->billPeriod,
            'standmeter1' => $req->content->postpaidBillInfos->previousMeterReading1,
            'standmeter2' => $req->content->postpaidBillInfos->currentMeterReading1,
            'tagihan' => $req->content->postpaidBillInfos->totalElectricityBill + $req->content->postpaidBillInfos->penaltyFee + $req->content->postpaidBillInfos->valueAddedTax,
            'admin_bank' => $admin_bank
        );
        array_push($detail_tagihan, $detail_tag);
    } else {
        for ($i = 0; $i < $dtrx->lembar; $i++) {
            $detail_tag = array(
                'billPeriod' => $req->content->postpaidBillInfos[$i]->billPeriod,
                'standmeter1' => $req->content->postpaidBillInfos[$i]->previousMeterReading1,
                'standmeter2' => $req->content->postpaidBillInfos[$i]->currentMeterReading1,
                'tagihan' => $req->content->postpaidBillInfos[$i]->totalElectricityBill + $req->content->postpaidBillInfos[$i]->penaltyFee + $req->content->postpaidBillInfos[$i]->valueAddedTax,
                'admin_bank' => $admin_bank
            );
            array_push($detail_tagihan, $detail_tag);
        }
    }
    $url_request = $fhasan->hasanahUrl() . 'get/payment/json/' . $fhasan->hasanahNoid() . '/' . $fhasan->hasanahToken() . '/' . $dtrx->idpel . '/' . $dtrx->tagihan . '/' . $reff;
    $response_asli = $fhasan->getCurlResult($url_request);

    libxml_use_internal_errors(true);

    $response_xml = simplexml_load_string($response_asli);

    if ($response_xml === false) {
        $response_code = '0099';
    }

    $response = json_encode($response_xml);
//    die($response);
    $arr = json_decode($response);
    $wLog->writeLog($interface, 'PAYMENT_PLN_POSTPAID', $response_xml);
} else {
    $req = json_decode($dtrx->log_biller);
    $detail_tagihan = array();
    for ($i = 0; $i < $dtrx->lembar; $i++) {
        if ($dtrx->lembar == 1) {
            $detail_tag = array(
                'billPeriod' => $req->content->postpaidBillInfos->billPeriod,
                'standmeter1' => $req->content->postpaidBillInfos->previousMeterReading1,
                'standmeter2' => $req->content->postpaidBillInfos->currentMeterReading1,
                'tagihan' => $req->content->postpaidBillInfos->totalElectricityBill + $req->content->postpaidBillInfos->penaltyFee + $req->content->postpaidBillInfos->valueAddedTax,
                'admin_bank' => $dtrx->admin_bank
            );
            array_push($detail_tagihan, $detail_tag);
        } else {
            $detail_tag = array(
                'billPeriod' => $req->content->postpaidBillInfos[$i]->billPeriod,
                'standmeter1' => $req->content->postpaidBillInfos[$i]->previousMeterReading1,
                'standmeter2' => $req->content->postpaidBillInfos[$i]->currentMeterReading1,
                'tagihan' => $req->content->postpaidBillInfos[$i]->totalElectricityBill + $req->content->postpaidBillInfos[$i]->penaltyFee + $req->content->postpaidBillInfos[$i]->valueAddedTax,
                'admin_bank' => $dtrx->admin_bank
            );
            array_push($detail_tagihan, $detail_tag);
        }
    }
    $simul = new Libraries\SimulatorHpay();
    $response = $simul->plnpostpaid('pay');
    $arr = json_decode($response);
}

if (isset($arr->responseCode)) {
    $response_code = '00' . str_replace('00', '', $arr->responseCode);
    if ($response_code == '0000') {
        $response_code = '0000';
        $astruk = array(
            'idpel' => $dtrx->idpel,
            'nama' => $dtrx->idpel_name,
            'segmen' => trim($arr->content->subscriberSegmentation),
            'daya' => $arr->content->powerConsumingCategory + 0,
            'detail' => $detail_tagihan,
            'lembar' => $dtrx->lembar,
            'reff' => $arr->content->switcherRefNum,
            'vsn' => $reff,
            'info' => $arr->content->infoText
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}

