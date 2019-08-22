<?php

//PAYMENT
//di dalam struk wajib ada vsn

$fhpay = new Libraries\FungsiHpay;
if ($environment == 'prod') {
    $req = json_decode($dtrx->log_biller);
    $reqxml = '<?xml version="1.0" encoding="UTF-8"?>'
                . '<hpay><channel>H2H</channel>'
                . '<hpayProduct>'
                    . '<productCode>000400040002</productCode>'
                    . '<admin>'. $dtrx->admin_bank .'</admin>'
                . '</hpayProduct>'
                . '<hpayTrxType>PAYMENT</hpayTrxType>'
                . '<account>'. $fhpay->hpayNoid() .'</account>'
                . '<content xsi:type="gspXMLPayRequestNontaglist" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'
                    . '<indexReversal>1</indexReversal>'
                    . '<adminCharge>'. $req->content->adminCharge .'</adminCharge>'
                    . '<areaCode>'. $req->content->areaCode .'</areaCode>'
                    . '<customDetails>'
                        . '<customDetailAmount>'. $req->content->customDetails->customDetailAmount .'</customDetailAmount>'
                        . '<customDetilCode>'. $req->content->customDetails->customDetilCode .'</customDetilCode>'
                        . '<minorUnitCustomDetail>'. $req->content->customDetails->minorUnitCustomDetail .'</minorUnitCustomDetail>'
                    . '</customDetails>'
                    . '<expirationDate>'. $req->content->expirationDate .'</expirationDate>'
                    . '<minorUnitAdminCharge>'. $req->content->minorUnitAdminCharge .'</minorUnitAdminCharge>'
                    . '<minorUnitPlnBill>'. $req->content->minorUnitPlnBill .'</minorUnitPlnBill>'
                    . '<minorUnitTransactionAmount>'. $req->content->minorUnitTransactionAmount .'</minorUnitTransactionAmount>'
                    . '<plnBillValue>'. $req->content->plnBillValue .'</plnBillValue>'
                    . '<plnRefNumber>'. $req->content->plnRefNumber .'</plnRefNumber>'
                    . '<registrationDate>'. $req->content->registrationDate .'</registrationDate>'
                    . '<registrationNumber>'. $req->content->registrationNumber .'</registrationNumber>'
                    . '<serviceUnit>'. $req->content->serviceUnit .'</serviceUnit>'
                    . '<serviceUnitAddress>'. $req->content->serviceUnitAddress .'</serviceUnitAddress>'
                    . '<serviceUnitPhone>'. $req->content->serviceUnitPhone .'</serviceUnitPhone>'
                    . '<subscriberId>'. $req->content->subscriberId .'</subscriberId>'
                    . '<subscriberName>'. $req->content->subscriberName .'</subscriberName>'
                    . '<switcherId>'. $req->content->switcherId .'</switcherId>'
                    . '<switcherRefNumber>'. $req->content->switcherRefNumber .'</switcherRefNumber>'
                    . '<totalAmount>'. $req->content->totalAmount .'</totalAmount>'
                    . '<totalRepeat>'. $req->content->totalRepeat .'</totalRepeat>'
                    . '<transactionAmount>'. $req->content->transactionAmount .'</transactionAmount>'
                    . '<transactionCode>'. $req->content->transactionCode .'</transactionCode>'
                    . '<transactionName>'. $req->content->transactionName .'</transactionName>'
                . '</content></hpay>';


    $response_asli = $fhpay->hpayCurl($fhpay->hpayUrl(), $reqxml, $fhpay->hpayHeader($reqxml));

    libxml_use_internal_errors(true);

    $response_xml = simplexml_load_string($response_asli);

    if ($response_xml === false) {
        $response_code = '0099';
    }

    $response = json_encode($response_xml);
//    die($response);
    $arr = json_decode($response);

    $wLog->writeLog($interface, 'PAYMENT_PLN_NONTAGLIST', $response_asli);
} else {
    $req = json_decode($dtrx->log_biller);
    $response = $fhpay->plnnontaglist('pay');
    $arr = json_decode($response);
}

if (isset($arr->responseCode)) {
    $response_code = '00' . str_replace('00', '', $arr->responseCode);
    if ($response_code == '0000') {
        $response_code = '0000';
        $astruk = array(
            'jenis' => $arr->content->transactionName,
            'no_reg' => $arr->content->registrationNumber,
            'tgl_reg' => $arr->content->registrationDate,
            'nama' => $dtrx->idpel_name,
            'idpel' => $arr->content->subscriberId,
            'vsn' => $reff,
            'ref' => $arr->content->switcherRefNumber,
            'admin' => $dtrx->admin_bank,
            'total' => $dtrx->total_tagihan,
            'info' => $arr->content->infoText
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}
