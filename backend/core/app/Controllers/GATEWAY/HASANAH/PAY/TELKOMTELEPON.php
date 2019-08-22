<?php

//PAYMENT
//di dalam struk wajib ada vsn

$fhasan = new Libraries\FungsiHasanah();
if ($environment == 'prod') {
    $url_request = $fhasan->hasanahUrl() . 'get/payment/json/' . $fhasan->hasanahNoid() . '/' . $fhasan->hasanahToken() . '/' . $dtrx->idpel . '/' . $dtrx->tagihan . '/' . $reff;
    $response_asli = $fhasan->getCurlResult($url_request);

    libxml_use_internal_errors(true);

    $response_xml = simplexml_load_string($response_asli);

    if ($response_xml === false) {
        $response_code = '0099';
    }

    $response = json_encode($response_xml);
    
    $arr = json_decode($response);

    $wLog->writeLog($interface, 'PAYMENT_TELKOM_TELEPON', $response_asli);
} else {
    $response = $fhpay->telkomtelepon('pay');
    $arr = json_decode($response);
}

if (isset($arr->responseCode)) {
    $response_code = '00' . str_replace('00', '', $arr->responseCode);
    if ($response_code == '00') {
        $response_code = '0000';
        $billPeriod = $fungsi->getNamaBulanShort(substr($arr->content->jastelBills->bulanTag, 4, 2)) 
                . substr($arr->content->jastelBills->bulanTag, 0, 4);

        $astruk = array(
            'idpel' => $dtrx->idpel,
            'nama' => $dtrx->idpel_name,
            'lembar' => $dtrx->lembar,
            'reff' => trim($arr->content->jastelBills->noRef),
            'vsn' => $reff,
            'bulan_tahun' => $billPeriod,
            'tagihan' => $dtrx->tagihan,
            'admin_bank' => $dtrx->admin_bank,
            'total_tagihan' => $dtrx->total_tagihan
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}

