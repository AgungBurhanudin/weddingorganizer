<?php

//PAYMENT
//di dalam struk wajib ada vsn

$fhasan = new Libraries\FungsiHasanah;
if ($environment == 'prod') {
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
            'nomor_meter' => $arr->content->meterSerialNumber,
            'idpel' => $arr->content->subscriberId,
            'nama' => $dtrx->idpel_name,
            'segmen' => trim($arr->content->subscriberSegmentation),
            'daya' => $arr->content->powerConsumingCategory + 0,
            'stroom' => $arr->content->powerPurchase / 100,
            'kwh' => $arr->content->purchaseKWHUnit,
            'vsn' => $reff,
            'ref' => $arr->content->swRefNumber,
            'angsuran' => $arr->content->customerPayablesInstallment,
            'meterai' => $arr->content->stampDuty,
            'ppn' => $arr->content->valueAddedTax,
            'ppj' => $arr->content->publicLightingTax / 100,
            'admin' => $dtrx->admin_bank,
            'total' => $dtrx->total_tagihan,
            'info' => $arr->content->infoText,
            'token' => $arr->content->tokenNumber
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}
