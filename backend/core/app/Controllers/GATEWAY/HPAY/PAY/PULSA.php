<?php

//PAYMENT
//di dalam struk wajib ada vsn


$fhpay = new Libraries\FungsiHpay;

$url_request = $fhpay->hpayUrl() . 'get/purchase/json/' . $fhpay->hpayNoid() . '/' . $fhpay->hpayNoid() . '/PULSA/' . $kode_h2h . '/' . $dtrx->idpel . '/0/0/' . $reff;
if ($environment == 'prod') {
    $response = $fhpay->getCurlResult($url_request);
    $wLog->writeLog($interface, 'PAYMENT_PULSA', $response);
} else {
    $simul = new Libraries\Simulator();
    $response = $simul->pulsa('pay');
}
$jresp = json_decode($response);
if (isset($jresp->response_code)) {
    $response_code = $jresp->response_code;
    if ($response_code == '0000') {
        $tagihan = $dtrx->tagihan;
        $admin_bank = $dtrx->admin_bank;
        $total_tagihan = $tagihan + $admin_bank;
        $astruk = array(
            'idpel' => $dtrx->idpel,
            'reff' => $jresp->detail->voucherSerialNumber,
            'vsn' => $reff,
            'jenis' => $kode_h2h,
            'harga' => $amount,
            'tagihan' => $tagihan,
            'admin_bank' => $admin_bank,
            'total_tagihan' => $total_tagihan
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}
