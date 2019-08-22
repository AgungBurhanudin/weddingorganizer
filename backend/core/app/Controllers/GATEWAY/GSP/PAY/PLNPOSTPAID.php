<?php

//PAYMENT
//di dalam struk wajib ada vsn

$fgsp = new Libraries\FungsiGsp;
if ($environment == 'prod') {
    $req = json_decode($dtrx->log_biller);
    $billInfos = '';
    $detail_tagihan = array();
    $admin_bank = $dtrx->admin_bank / $dtrx->lembar;

    for ($i = 0; $i < $dtrx->lembar; $i++) {
        $detail_tag = array(
            'billPeriod' => $req->detail[$i]->billPeriod,
            'standmeter1' => $req->detail[$i]->prevMeterReading,
            'standmeter2' => $req->detail[$i]->currentMeterReading,
            'tagihan' => $req->detail[$i]->totalElectricityBill + $req->detail[$i]->penaltyFee + $req->detail[$i]->valueAddedTax,
            'admin_bank' => $admin_bank
        );
        array_push($detail_tagihan, $detail_tag);
    }

    $url_request = $fgsp->gspUrl() . 'SapulindoPLNISOSwitch/postpaid_payment.jsp';
    $param = '{"traceID": "'.$reff.'","merchantCode": "6025","userID": "42344",'
            . '"idpel": "'.$dtrx->idpel.'","admin": "'.$admin_bank.'","amount": "'
            . $req->amount.'","isoMessage": "'.str_replace("`", "'", $req->isoMessage).'"}';
    $response_asli = $fgsp->getCurlResult($url_request,$param);

//    die($response);
    $response = str_replace("'", "`", $response_asli);
    $arr = json_decode($response);
    $wLog->writeLog($interface, 'PAYMENT_PLN_POSTPAID', $response_asli);
} else {
    $req = json_decode($dtrx->log_biller);
    $detail_tagihan = array();
    for ($i = 0; $i < $dtrx->lembar; $i++) {
        $detail_tag = array(
            'billPeriod' => $req->detail[$i]->billPeriod,
            'standmeter1' => $req->detail[$i]->previousMeterReading1,
            'standmeter2' => $req->detail[$i]->currentMeterReading1,
            'tagihan' => $req->detail[$i]->totalElectricityBill + $req->detail[$i]->penaltyFee + $req->detail[$i]->valueAddedTax,
            'admin_bank' => $admin_bank
        );
        array_push($detail_tagihan, $detail_tag);
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
            'nama' => str_replace("`", "'",$dtrx->idpel_name),
            'segmen' => trim($arr->subscriberSegmentation),
            'daya' => $arr->powerConsumingCategory + 0,
            'detail' => $detail_tagihan,
            'lembar' => $dtrx->lembar,
            'reff' => $arr->switcherRefNum,
            'vsn' => $reff,
            'info' => $arr->infoText
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}

