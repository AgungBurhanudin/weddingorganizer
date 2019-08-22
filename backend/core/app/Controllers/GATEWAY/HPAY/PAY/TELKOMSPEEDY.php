<?php

//PAYMENT
//di dalam struk wajib ada vsn

$fhpay = new Libraries\FungsiHpay;
if ($environment == 'prod') {
    $req = json_decode($dtrx->log_biller);
    $reqxml = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<hpay><channel>H2H</channel>'
            . '<hpayProduct>'
                . '<productCode>000200020001</productCode>'
                . '<admin>' . $dtrx->admin_bank . '</admin>'
            . '</hpayProduct>'
            . '<hpayTrxType>PAYMENT</hpayTrxType>'
            . '<account>' . $fhpay->hpayNoid() . '</account>'
            . '<content xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="jastelXMLPayRequest">'
                . '<indexReversal>1</indexReversal>'
                . '<traceNum>' . $reff . '</traceNum>'
                . '<jastelBills index="1">'
                    . '<bulanTag>'.$req->content->jastelBills->bulanTag.'</bulanTag>'
                    . '<nilaiTagihan>'.$req->content->jastelBills->nilaiTagihan.'</nilaiTagihan>'
                    . '<noRef>'.$req->content->jastelBills->noRef.'</noRef>'
                . '</jastelBills>'
                . '<jmlBill>'.$req->content->jmlBill.'</jmlBill>'
                . '<kodeArea>'.$req->content->kodeArea.'</kodeArea>'
                . '<kodeDatel>'.$req->content->kodeDatel.'</kodeDatel>'
                . '<kodeDivre>'.$req->content->kodeDivre.'</kodeDivre>'
                . '<namaPelanggan>'.$req->content->namaPelanggan.'</namaPelanggan>'
                . '<noTelp>'.$req->content->noTelp.'</noTelp>'
                . '<npwp></npwp>'
                . '<totalAmount>'.$req->content->totalAmount.'</totalAmount>'
            . '</content>'
            . '</hpay>';

    $response_asli = $fhpay->hpayCurl($fhpay->hpayUrl(), $reqxml, $fhpay->hpayHeader($reqxml));

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

