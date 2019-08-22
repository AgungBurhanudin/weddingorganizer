<?php

//PAYMENT
//di dalam struk wajib ada vsn

$fgsp = new Libraries\FungsiGsp;
if ($environment == 'prod') {
    $req = json_decode($dtrx->log_biller);
    $url_request = $fgsp->gspUrl() . 'SapulindoPLNISOSwitch/prepaid_payment.jsp';
    $param = '{"traceID": "'.$reff.'","merchantCode": "6025","userID": "42344",'
            . '"idpel": "'.$dtrx->idpel.'","admin": "'.$dtrx->admin_bank.'","amount": "'
            . $dtrx->tagihan.'","isoMessage": "'.str_replace("`", "'", $req->isoMessage).'"}';
    $response_asli = $fgsp->getCurlResult($url_request,$param);

//    die($response);
    $response = str_replace("'", "`", $response_asli);
    $arr = json_decode($response);

    $wLog->writeLog($interface, 'PAYMENT_PLN_PREPAID', $response_asli);
} else {
    $simul = new Libraries\SimulatorHpay();
    $response = $simul->plnprepaid('pay');
    $arr = json_decode($response);
}

if (isset($arr->responseCode)) {
    $response_code = '00' . str_replace('00', '', $arr->responseCode);
    if ($response_code == '0000') {
        $response_code = '0000';
        $astruk = array(
            'nomor_meter' => $arr->meterSerialNumber,
            'idpel' => $arr->subscriberId,
            'nama' => str_replace("`", "'",$dtrx->idpel_name),
            'segmen' => trim($arr->subscriberSegmentation),
            'daya' => $arr->powerConsumingCategory + 0,
            'stroom' => $arr->powerPurchase / 100,
            'kwh' => $arr->purchaseKWHUnit,
            'vsn' => $reff,
            'ref' => $arr->swRefNumber,
            'angsuran' => $arr->customerPayablesInstallment,
            'meterai' => $arr->stampDuty,
            'ppn' => $arr->valueAddedTax,
            'ppj' => $arr->publicLightingTax / 100,
            'admin' => $dtrx->admin_bank,
            'total' => $dtrx->total_tagihan,
            'info' => $arr->infoText,
            'token' => $arr->tokenNumber
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}
