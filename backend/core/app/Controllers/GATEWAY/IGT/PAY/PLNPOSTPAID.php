<?php

//PAYMENT
//di dalam struk wajib ada vsn

$figt = new Libraries\FungsiIgt;

$url_request = $figt->igtUrl() . 'get/payment/json/' . $figt->igtNoid() . '/' . $figt->igtToken() . '/' . $dtrx->idpel . '/' . $dtrx->tagihan . '/' . $reff;
if ($environment == 'prod') {
    $response = $figt->getCurlResult($url_request);
    $wLog->writeLog($interface, 'PAYMENT_PLN_POSTPAID', $response);
} else {
    $simul = new Libraries\Simulator();
    $response = $simul->plnpostpaid('pay');
}
$jresp = json_decode($response);
if (isset($jresp->response_code)) {
    $response_code = $jresp->response_code;
    if ($response_code == '0000') {
        $astruk = array(
            'idpel' => $dtrx->idpel,
            'nama' => $dtrx->idpel_name,
            'segmen' => trim($jresp->tarif),
            'daya' => $jresp->daya + 0,
            'detail' => $jresp->detail,
            'lembar' =>$dtrx->lembar,
            'reff' =>$jresp->reff,
            'vsn' =>$reff,
            'info' =>$jresp->ori->infoText
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}

