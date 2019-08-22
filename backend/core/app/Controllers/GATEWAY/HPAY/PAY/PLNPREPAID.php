<?php

//PAYMENT
//di dalam struk wajib ada vsn

$fhpay = new Libraries\FungsiHpay;
if ($environment == 'prod') {
    $req = json_decode($dtrx->log_biller);
    $reqxml ='<?xml version="1.0" encoding="UTF-8"?>'
                . '<hpay><channel>H2H</channel>'
                . '<hpayProduct>'
                    . '<productCode>000400040003</productCode>'
                    . '<admin>'. $dtrx->admin_bank .'</admin>'
                . '</hpayProduct>'
                . '<hpayTrxType>PAYMENT</hpayTrxType>'
                . '<account>'. $fhpay->hpayNoid() .'</account>'
                . '<content xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="gspXMLPurchaseRequestPrepaid">'
                    . '<indexReversal>1</indexReversal>'
                    . '<traceNum>'.$reff.'</traceNum>'
                    . '<adminCharge>'.$req->content->adminCharge.'</adminCharge>'
                    . '<distributionCode>'.$req->content->distributionCode.'</distributionCode>'
                    . '<flag>'.$req->content->flag.'</flag>'
                    . '<maxKWHLimit>'.$req->content->maxKWHLimit.'</maxKWHLimit>'
                    . '<meterSerialNumber>'.$req->content->meterSerialNumber.'</meterSerialNumber>'
                    . '<minorUnitofAdminCharge>'.$req->content->minorUnitofAdminCharge.'</minorUnitofAdminCharge>'
                    . '<plnRefNumber></plnRefNumber>'
                    . '<powerConsumingCategory>'.$req->content->powerConsumingCategory.'</powerConsumingCategory>'
                    . '<serviceUnit>'.$req->content->serviceUnit.'</serviceUnit>'
                    . '<serviceUnitPhone>'.$req->content->serviceUnitPhone.'</serviceUnitPhone>'
                    . '<subscriberId>'.$req->content->subscriberId.'</subscriberId>'
                    . '<subscriberName>'.$req->content->subscriberName.'</subscriberName>'
                    . '<subscriberSegmentation>'.$req->content->subscriberSegmentation.'</subscriberSegmentation>'
                    . '<swRefNumber>'.$req->content->swRefNumber.'</swRefNumber>'
                    . '<switcherId>'.$req->content->switcherId.'</switcherId>'
                    . '<totalAmount>'.$dtrx->tagihan.'</totalAmount>'
                    . '<totalRepeat>'.$req->content->totalRepeat.'</totalRepeat>'
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

    $wLog->writeLog($interface, 'PAYMENT_PLN_PREPAID', $response_asli);
} else {
    $response = $fhpay->plnprepaid('pay');
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
