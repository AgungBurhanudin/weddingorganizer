<?php

//PAYMENT
//di dalam struk wajib ada vsn

$figt = new Libraries\FungsiIgt;

$url_request = $figt->igtUrl() . 'get/payment/json/' . $figt->igtNoid() . '/' . $figt->igtToken() . '/' . $dtrx->idpel . '/' . $dtrx->tagihan . '/' . $reff;
if ($environment == 'prod') {
    $response = $figt->getCurlResult($url_request);
    $wLog->writeLog($interface, 'PAYMENT_PLN_PREPAID', $response);
} else {
    $simul = new Libraries\Simulator();
    $response = $simul->plnprepaid('pay');        
}
$jresp = json_decode($response);
if (isset($jresp->response_code)) {
    $response_code = $jresp->response_code;
    if ($response_code == '0000') {
        $astruk = array(
            'nomor_meter' => $jresp->no_meter,
            'idpel' => $dtrx->idpel,
            'nama' => $dtrx->idpel_name,
            'segmen' => trim($jresp->tarif),
            'daya' => $jresp->daya + 0,
            'stroom' => $jresp->stroom,
            'kwh' => $jresp->jml_kwh,
            'vsn' => $reff,
            'ref' => $jresp->reff,
            'angsuran' => $jresp->ori->customerPayablesInstallment,
            'meterai' => $jresp->materai,
            'ppn' => $jresp->ppn,
            'ppj' => $jresp->ppj,
            'admin' => $dtrx->admin_bank,
            'total' => $dtrx->total_tagihan,
            'info' => $jresp->ori->infoText,
            'token' => $jresp->token
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}
