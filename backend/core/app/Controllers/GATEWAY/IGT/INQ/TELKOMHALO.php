<?php

//INQUIRY

$figt = new Libraries\FungsiIgt;

if (strlen($idpel) > 13 || strlen($idpel) < 8 || is_numeric($idpel) == FALSE) {
    $response_code = "0014";
} else {
    $url_request = $figt->igtUrl() . 'get/inquiry/json/' . $figt->igtNoid() . '/' . $figt->igtToken() . '/TELKOM/TELEPON/' . $idpel . '/' . $admin_bank . '/' . $reff;
    if ($environment == 'prod') {
        $response = $figt->getCurlResult($url_request);
        $wLog->writeLog($interface, 'INQUIRY_TELKOM_TELEPON', $response);
    } else {
        $simul = new Libraries\Simulator();
        $response = $simul->telkomhalo('inq');
    }
    $arr = json_decode($response);
    if (isset($arr->response_code)) {
        $response_code = $arr->response_code;
        if ($response_code == '0000') {

            $billPeriod = $fungsi->getNamaBulanShort(substr($arr->detail->jastelBills->bulanTag, 4, 2)) . substr($arr->detail->jastelBills->bulanTag, 0, 4);

            $tagihan = $arr->tagihan;
            $lembar = $arr->lembar;
            $admin_bank = $admin_bank * $lembar;
            $total_tagihan = $tagihan + $admin_bank;
            $idpel_name = trim($arr->detail->namaPelanggan);
            $bulan_thn = $billPeriod;

            $jh = array();
            $jh[0][0] = 'PEMBAYARAN';
            $jh[0][1] = $product . ' ' . $product_detail;
            $jh[1][0] = 'NOMOR HP';
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
