<?php

//INQUIRY

$figt = new Libraries\FungsiIgt;

if (strlen($idpel) > 12 || strlen($idpel) < 11 || is_numeric($idpel) == FALSE) {
    $response_code = "0014";
} else {
    $url_request = $figt->igtUrl() . 'get/inquiry/json/' . $figt->igtNoid() . '/' . $figt->igtToken() . '/PLN/PREPAID/' . $idpel . '/' . $admin_bank . '/' . $reff;
    if ($environment == 'prod') {
        $response = $figt->getCurlResult($url_request);
        $wLog->writeLog($interface, 'INQUIRY_PLN_PREPAID', $response);
    } else {
        $simul = new Libraries\Simulator();
        $response = $simul->plnprepaid('inq');
    }
    $arr = json_decode($response);
    if (isset($arr->response_code)) {
        $response_code = $arr->response_code;
        if ($response_code == '0000') {

            $tagihan = $nominal;
            $total_tagihan = $tagihan + $admin_bank;
            $lembar = 1;
            $idpel_name = trim($arr->nama);
            $daya = $arr->daya + 0;

            $jh = array();
            $jh[0][0] = 'PEMBELIAN';
            $jh[0][1] = $product . ' ' . $product_detail;
            $jh[1][0] = 'IDPEL';
            $jh[1][1] = $arr->idpel;
            $jh[2][0] = 'NOMOR METER';
            $jh[2][1] = $arr->serial_meter;
            $jh[3][0] = 'NAMA';
            $jh[3][1] = $idpel_name;
            $jh[4][0] = 'DAYA';
            $jh[4][1] = $daya . ' VA';
            $jh[5][0] = 'RP TAG';
            $jh[5][1] = $fungsi->rupiah($tagihan);
            $jh[6][0] = 'ADMIN BANK';
            $jh[6][1] = $fungsi->rupiah($admin_bank);
            $jh[7][0] = 'TOTAL BAYAR';
            $jh[7][1] = $fungsi->rupiah($total_tagihan);
            $response_html = $fHtml->jsonToHtml($jh);
        }
    } else {
        $response_code = '0099';
    }
}