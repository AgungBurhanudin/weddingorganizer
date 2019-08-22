<?php

//PAYMENT
//di dalam struk wajib ada vsn

$fhpay = new Libraries\FungsiHpay;
if ($environment == 'prod') {
    $req = json_decode($dtrx->log_biller);
    $billInfos = '';
    $detail_tagihan = array();
    $admin_bank = $dtrx->admin_bank / $dtrx->lembar;
    if ($dtrx->lembar == 1) {
        $billInfos .= '<postpaidBillInfos>'
                . '<billPeriod>' . $req->content->postpaidBillInfos->billPeriod . '</billPeriod>'
                . '<currentMeterReading1>' . $req->content->postpaidBillInfos->currentMeterReading1 . '</currentMeterReading1>'
                . '<currentMeterReading2>' . $req->content->postpaidBillInfos->currentMeterReading2 . '</currentMeterReading2>'
                . '<currentMeterReading3>' . $req->content->postpaidBillInfos->currentMeterReading3 . '</currentMeterReading3>'
                . '<dueDate>' . $req->content->postpaidBillInfos->dueDate . '</dueDate>'
                . '<incentive>' . $req->content->postpaidBillInfos->incentive . '</incentive>'
                . '<meterReadDate>' . $req->content->postpaidBillInfos->meterReadDate . '</meterReadDate>'
                . '<penaltyFee>' . $req->content->postpaidBillInfos->penaltyFee . '</penaltyFee>'
                . '<previousMeterReading1>' . $req->content->postpaidBillInfos->previousMeterReading1 . '</previousMeterReading1>'
                . '<previousMeterReading2>' . $req->content->postpaidBillInfos->previousMeterReading2 . '</previousMeterReading2>'
                . '<previousMeterReading3>' . $req->content->postpaidBillInfos->previousMeterReading3 . '</previousMeterReading3>'
                . '<totalElectricityBill>' . $req->content->postpaidBillInfos->totalElectricityBill . '</totalElectricityBill>'
                . '<valueAddedTax>' . $req->content->postpaidBillInfos->valueAddedTax . '</valueAddedTax>'
                . '</postpaidBillInfos>';
        $detail_tag = array(
            'billPeriod' => $req->content->postpaidBillInfos->billPeriod,
            'standmeter1' => $req->content->postpaidBillInfos->previousMeterReading1,
            'standmeter2' => $req->content->postpaidBillInfos->currentMeterReading1,
            'tagihan' => $req->content->postpaidBillInfos->totalElectricityBill + $req->content->postpaidBillInfos->penaltyFee + $req->content->postpaidBillInfos->valueAddedTax,
            'admin_bank' => $admin_bank
        );
        array_push($detail_tagihan, $detail_tag);
    } else {
        for ($i = 0; $i < $dtrx->lembar; $i++) {
            $billInfos .= '<postpaidBillInfos>'
                    . '<billPeriod>' . $req->content->postpaidBillInfos[$i]->billPeriod . '</billPeriod>'
                    . '<currentMeterReading1>' . $req->content->postpaidBillInfos[$i]->currentMeterReading1 . '</currentMeterReading1>'
                    . '<currentMeterReading2>' . $req->content->postpaidBillInfos[$i]->currentMeterReading2 . '</currentMeterReading2>'
                    . '<currentMeterReading3>' . $req->content->postpaidBillInfos[$i]->currentMeterReading3 . '</currentMeterReading3>'
                    . '<dueDate>' . $req->content->postpaidBillInfos[$i]->dueDate . '</dueDate>'
                    . '<incentive>' . $req->content->postpaidBillInfos[$i]->incentive . '</incentive>'
                    . '<meterReadDate>' . $req->content->postpaidBillInfos[$i]->meterReadDate . '</meterReadDate>'
                    . '<penaltyFee>' . $req->content->postpaidBillInfos[$i]->penaltyFee . '</penaltyFee>'
                    . '<previousMeterReading1>' . $req->content->postpaidBillInfos[$i]->previousMeterReading1 . '</previousMeterReading1>'
                    . '<previousMeterReading2>' . $req->content->postpaidBillInfos[$i]->previousMeterReading2 . '</previousMeterReading2>'
                    . '<previousMeterReading3>' . $req->content->postpaidBillInfos[$i]->previousMeterReading3 . '</previousMeterReading3>'
                    . '<totalElectricityBill>' . $req->content->postpaidBillInfos[$i]->totalElectricityBill . '</totalElectricityBill>'
                    . '<valueAddedTax>' . $req->content->postpaidBillInfos[$i]->valueAddedTax . '</valueAddedTax>'
                    . '</postpaidBillInfos>';
            $detail_tag = array(
                'billPeriod' => $req->content->postpaidBillInfos[$i]->billPeriod,
                'standmeter1' => $req->content->postpaidBillInfos[$i]->previousMeterReading1,
                'standmeter2' => $req->content->postpaidBillInfos[$i]->currentMeterReading1,
                'tagihan' => $req->content->postpaidBillInfos[$i]->totalElectricityBill + $req->content->postpaidBillInfos[$i]->penaltyFee + $req->content->postpaidBillInfos[$i]->valueAddedTax,
                'admin_bank' => $admin_bank
            );
            array_push($detail_tagihan, $detail_tag);
        }
    }
    $reqxml = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<hpay><channel>H2H</channel>'
            . '<hpayProduct>'
            . '<productCode>000400040001</productCode>'
            . '<admin>' . $dtrx->admin_bank . '</admin>'
            . '</hpayProduct>'
            . '<hpayTrxType>PAYMENT</hpayTrxType>'
            . '<account>' . $fhpay->hpayNoid() . '</account>'
            . '<content xsi:type="gspXMLPayRequestPostpaid" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'
            . '<indexReversal>1</indexReversal>'
            . '<billStatus>' . $req->content->billStatus . '</billStatus>'
            . $billInfos
            . '<powerConsumingCategory>' . $req->content->powerConsumingCategory . '</powerConsumingCategory>'
            . '<serviceUnit>' . $req->content->serviceUnit . '</serviceUnit>'
            . '<serviceUnitPhone>' . $req->content->serviceUnitPhone . '</serviceUnitPhone>'
            . '<subscriberId>' . $req->content->subscriberId . '</subscriberId>'
            . '<subscriberName>' . $req->content->subscriberName . '</subscriberName>'
            . '<subscriberSegmentation>' . $req->content->subscriberSegmentation . '</subscriberSegmentation>'
            . '<switcherId>' . $req->content->switcherId . '</switcherId>'
            . '<switcherRefNum>' . $req->content->switcherRefNum . '</switcherRefNum>'
            . '<totalAdminCharges>' . $req->content->totalAdminCharges . '</totalAdminCharges>'
            . '<totalAmount>' . $req->content->totalAmount . '</totalAmount>'
            . '<totalOutstandingBill>' . $req->content->totalOutstandingBill . '</totalOutstandingBill>'
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
    $wLog->writeLog($interface, 'PAYMENT_PLN_POSTPAID', $response_xml);
} else {
    $req = json_decode($dtrx->log_biller);
    $detail_tagihan = array();
    for ($i = 0; $i < $dtrx->lembar; $i++) {
        if ($dtrx->lembar == 1) {
            $detail_tag = array(
                'billPeriod' => $req->content->postpaidBillInfos->billPeriod,
                'standmeter1' => $req->content->postpaidBillInfos->previousMeterReading1,
                'standmeter2' => $req->content->postpaidBillInfos->currentMeterReading1,
                'tagihan' => $req->content->postpaidBillInfos->totalElectricityBill + $req->content->postpaidBillInfos->penaltyFee + $req->content->postpaidBillInfos->valueAddedTax,
                'admin_bank' => $dtrx->admin_bank
            );
            array_push($detail_tagihan, $detail_tag);
        } else {
            $detail_tag = array(
                'billPeriod' => $req->content->postpaidBillInfos[$i]->billPeriod,
                'standmeter1' => $req->content->postpaidBillInfos[$i]->previousMeterReading1,
                'standmeter2' => $req->content->postpaidBillInfos[$i]->currentMeterReading1,
                'tagihan' => $req->content->postpaidBillInfos[$i]->totalElectricityBill + $req->content->postpaidBillInfos[$i]->penaltyFee + $req->content->postpaidBillInfos[$i]->valueAddedTax,
                'admin_bank' => $dtrx->admin_bank
            );
            array_push($detail_tagihan, $detail_tag);
        }
    }
    $response = $fhpay->plnpostpaid('pay');
    $arr = json_decode($response);
}

if (isset($arr->responseCode)) {
    $response_code = '00' . str_replace('00', '', $arr->responseCode);
    if ($response_code == '0000') {
        $response_code = '0000';
        $astruk = array(
            'idpel' => $dtrx->idpel,
            'nama' => $dtrx->idpel_name,
            'segmen' => trim($arr->content->subscriberSegmentation),
            'daya' => $arr->content->powerConsumingCategory + 0,
            'detail' => $detail_tagihan,
            'lembar' => $dtrx->lembar,
            'reff' => $arr->content->switcherRefNum,
            'vsn' => $reff,
            'info' => $arr->content->infoText
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}

