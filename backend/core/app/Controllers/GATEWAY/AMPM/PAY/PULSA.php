<?php

//PAYMENT
//di dalam struk wajib ada vsn


$fampm = new Libraries\FungsiAmpm();
//http://36.37.85.130:9998/trx?memberid=[memberid]&dest=[tujuan]&product=[kode produk]&refid=[trxid]&pin=[pin]&password=[password]
$url_request = $fampm->ampmUrl() . 'trx?memberid=' . $fampm->ampmNoid() . '&dest=' . $dtrx->idpel . '&product=' . $kode_h2h . '&refid=' . $reff . '&pin=' . $fampm->ampmPin() . '&password=' . $fampm->ampmPasswod();
if ($environment == 'prod') {
    $response = $fampm->getCurlResult($url_request);
    $wLog->writeLog($interface, 'PAYMENT_PULSA', $response);
    
    //fungsi pembaca balasan ampm
    $arr_response = explode('#', $response);
    
    $voucherSerialNumber = '';
    if($arr_response[4] == 'SUKSES'){
        $response_code = '0000';
        $voucherSerialNumber = '';
    } elseif (substr($arr_response[4],0,4) == 'akan' || substr($arr_response[4],0,4) == 'masi') {
        $response_code = '0099';
        $voucherSerialNumber = '';
    } elseif (substr($arr_response[4],0,5) == 'GAGAL'){
        $response_code = '0010';
    } else{
        $response_code = '0099';
        $voucherSerialNumber = '';
    }
} else {
    $simul = new Libraries\Simulator();
    $response = $simul->pulsa('pay');
}


    $response_code = $jresp->response_code;
    if ($response_code == '0000') {
        $tagihan = $dtrx->tagihan;
        $admin_bank = $dtrx->admin_bank;
        $total_tagihan = $tagihan + $admin_bank;
        $astruk = array(
            'idpel' => $dtrx->idpel,
            'reff' => $voucherSerialNumber,
            'vsn' => $reff,
            'jenis' => $kode_h2h,
            'harga' => $amount,
            'tagihan' => $tagihan,
            'admin_bank' => $admin_bank,
            'total_tagihan' => $total_tagihan
        );
        $struk = json_encode($astruk);
    }

