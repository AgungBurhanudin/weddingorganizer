<?php

//PAYMENT
//di dalam struk wajib ada vsn

$fhpay = new Libraries\FungsiHpay;
if ($environment == 'prod') {
    $req = json_decode($dtrx->log_biller);
    $billInfos = '';
    $jml_billInfos = count($req->content->billsInfo);
    for ($i = 0; $i < $jml_billInfos; $i++) {
        if(isset($req->content->billsInfo[$i]->kodeCabang->{0})){
            $kodeCabang = $req->content->billsInfo[$i]->kodeCabang->{0};
            $namaCabang = $req->content->billsInfo[$i]->namaCabang->{0};
            $namaPelanggan = $req->content->billsInfo[$i]->namaPelanggan->{0};
            $nomorPelanggan = $req->content->billsInfo[$i]->nomorPelanggan->{0};
        }else{
            $kodeCabang = $req->content->billsInfo[$i]->kodeCabang;
            $namaCabang = $req->content->billsInfo[$i]->namaCabang;
            $namaPelanggan = $req->content->billsInfo[$i]->namaPelanggan;
            $nomorPelanggan = $req->content->billsInfo[$i]->nomorPelanggan;
        }
        $billInfos .= '<billsInfo>'
                . '<kodeCabang>' . $kodeCabang . '</kodeCabang>'
                . '<namaCabang>' . $namaCabang . '</namaCabang>'
                . '<namaPelanggan>' . $namaPelanggan . '</namaPelanggan>'
                . '<nomorPelanggan>' . $nomorPelanggan . '</nomorPelanggan>'
                . '<saldo>' . $req->content->billsInfo[$i]->saldo . '</saldo>'
                . '<tagihanPremi>' . $req->content->billsInfo[$i]->tagihanPremi . '</tagihanPremi>'
                . '</billsInfo>';
    }
    if(isset($req->content->noTelp->{0})){
        $noTelp = $req->content->noTelp->{0};
    }else{
        $noTelp = $req->content->noTelp;
    }
    $reqxml = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<hpay><channel>H2H</channel>'
            . '<hpayProduct>'
            . '<productCode>000200020013</productCode>'
            . '<admin>' . $dtrx->admin_bank . '</admin>'
            . '</hpayProduct>'
            . '<hpayTrxType>PAYMENT</hpayTrxType>'
            . '<account>' . $fhpay->hpayNoid() . '</account>'
            . '<content xsi:type="bpjsKeluargaXMLPayRequest" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'
            . '<indexReversal>1</indexReversal>'
            . '<jmlBulan>' . $req->content->jmlBulan . '</jmlBulan>'
            . $billInfos
            . '<noReferensi>' . $req->content->noReferensi . '</noReferensi>'
            . '<noTelp>' . $noTelp . '</noTelp>'
            . '<nomorPelanggan>' . $req->content->nomorPelanggan . '</nomorPelanggan>'
            . '<totalAmount>' . $req->content->totalAmount . '</totalAmount>'
            . '<totalAnggota>' . $req->content->totalAnggota . '</totalAnggota>'
            . '<totalPremi>' . $req->content->totalPremi . '</totalPremi>'
            . '<totalSaldo>' . $req->content->totalSaldo . '</totalSaldo>'
            . '</content></hpay>';

    $response_asli = $fhpay->hpayCurl($fhpay->hpayUrl(), $reqxml, $fhpay->hpayHeader($reqxml));
    
    libxml_use_internal_errors(true);
    
    $response_xml = simplexml_load_string($response_asli);

    if ($response_xml === false) {
        $response_code = '0099';
    }

    $response = json_encode($response_xml);
    
    $arr = json_decode($response);
    $wLog->writeLog($interface, 'PAYMENT_BPJS', $response_asli);
} else {    
    $response = $fhpay->bpjskesehatan('pay');
    $arr = json_decode($response);
}

if (isset($arr->responseCode)) {
    $response_code = '00' . str_replace('00', '', $arr->responseCode);
    if ($response_code == '0000') {
        $response_code = '0000';
        $astruk = array(
            'idpel' => $dtrx->idpel,
            'nama' => $dtrx->idpel_name,
            'lembar' => $dtrx->lembar,
            'tagihan' => $dtrx->tagihan,
            'admin_bank' => $dtrx->admin_bank,
            'total_tagihan' => $dtrx->total_tagihan,
            'reff' => $arr->content->noReferensi,
            'vsn' => $reff
        );
        $struk = json_encode($astruk);
    }
} else {
    $response_code = '0099';
}
