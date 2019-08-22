<?php

//INQUIRY

$fhasan = new Libraries\FungsiHasanah();

if (strlen($idpel) > 15 || strlen($idpel) < 8) {
    $response_code = "0014";
} else {
    $arr_idpel = explode('-', $idpel);
    $kodeArea = $arr_idpel[0];
    $noTelp = $arr_idpel[1];
    if ($environment == 'prod') {
        $url_request = $fhasan->hasanahUrl() . 'get/inquiry/json/' . $fhasan->hasanahNoid() . '/' . $fhasan->hasanahToken() . '/TELKOM/TELEPON/' . $idpel . '/' . $admin_bank . '/' . $reff;
        
        $response_asli = $fhasan->getCurlResult($url_request);
        
        libxml_use_internal_errors(true);

        $response_xml = simplexml_load_string($response_asli);

        if ($response_xml === false) {
            $response_code = '0099';
        }

        $response = json_encode($response_xml);
        $arr = json_decode($response);
        $wLog->writeLog($interface, 'INQUIRY_TELKOM_TELEPON', $idpel . ' >> ' . $response_asli);
    } else {
        $response = $fhpay->telkomtelepon('inq');
        $arr = json_decode($response);
    }
    
    if (isset($arr->responseCode)) {
        $response_code = '00' . str_replace('00', '', $arr->responseCode);
        if ($response_code == '00') {
            $response_code = '0000';
            $log_biller = $response;
            $billPeriod = $fungsi->getNamaBulanShort(substr($arr->content->jastelBills->bulanTag, 4, 2)) 
                    . substr($arr->content->jastelBills->bulanTag, 0, 4);

            $tagihan = $arr->content->totalAmount;
            $lembar = $arr->content->jmlBill;
            $admin_bank = $admin_bank * $lembar;
            $total_tagihan = $tagihan + $admin_bank;
            $idpel_name = strtoupper(trim($arr->content->namaPelanggan));
            $bulan_thn = $billPeriod;

            $jh = array();
            $jh[0][0] = 'PEMBAYARAN';
            $jh[0][1] = $product . ' ' . $product_detail;
            $jh[1][0] = 'NOMOR TELEPON';
            $jh[1][1] = $idpel;
            $jh[2][0] = 'NAMA';
            $jh[2][1] = $idpel_name;
            $jh[3][0] = 'TOTAL TAGIHAN';
            $jh[3][1] = $lembar . ' BULAN';
            $jh[4][0] = 'BL/THN';
            $jh[4][1] = $bulan_thn;
            $jh[5][0] = 'TAGIHAN';
            $jh[5][1] = $fungsi->rupiah($tagihan);
            $jh[6][0] = 'ADMIN BANK';
            $jh[6][1] = $fungsi->rupiah($admin_bank);
            $jh[7][0] = 'TOTAL TAGIHAN';
            $jh[7][1] = $fungsi->rupiah($total_tagihan);
            $response_html = $fHtml->jsonToHtml($jh);
        }
    } else {
        $response_code = '0099';
    }
}
