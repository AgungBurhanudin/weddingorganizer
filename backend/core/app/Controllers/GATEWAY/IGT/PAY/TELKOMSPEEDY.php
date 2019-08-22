<?php

//PAYMENT
//di dalam struk wajib ada vsn

$figt = new Libraries\FungsiIgt;

$url_request = $figt->igtUrl() . 'get/payment/json/' . $figt->igtNoid() . '/' . $figt->igtToken() . '/' . $dtrx->idpel . '/' . $dtrx->tagihan . '/' . $reff;
if ($environment == 'prod') {
    $response = $figt->getCurlResult($url_request);
    $wLog->writeLog($interface, 'PAYMENT_TELKOM_SPEEDY', $response);
    
} else {
    $simul = new Libraries\Simulator();
    $response = $simul->telkomspeedy('pay');
}
$jresp = json_decode($response);
if (isset($jresp->response_code)) {
    $response_code = $jresp->response_code;
    if ($response_code == '0000') {
        $billPeriod = $fungsi->getNamaBulanShort(substr($jresp->detail->jastelBills->bulanTag, 4, 2)) .' '. substr($jresp->detail->jastelBills->bulanTag, 0, 4);
        $tagihan = $jresp->tagihan;
        $lembar = $jresp->content->jmlBill;
        $admin_bank = $dtrx->admin_bank * $lembar;
        $total_tagihan = $tagihan + $admin_bank;
        $astruk = array(
            'idpel' => $dtrx->idpel,
            'nama' => $dtrx->idpel_name,
            'lembar' => $dtrx->lembar,
            'reff' => $jresp->content->jastelBills->noRef,
            'vsn' => $reff,
            'bulan_tahun' => $billPeriod,
            'tagihan' => $tagihan,
            'admin_bank' => $admin_bank,
            'total_tagihan' => $total_tagihan
        );
    }
} else {
    $response_code = '0099';
}
$struk = json_encode($astruk);
