<?php
$dbbi = new Models\DbBilling();

$dest_add = strtoupper($jreq->detail->idtagihan);
$arr = $dbbi->cekIdTagihanVa($dest_add);
if (isset($arr->id)) {
    $response = array(
        'response_code' => '0000',
        'response_message' => 'CEK DATA TAGIHAN',
        'noid' => $arr->noid,
        'jenis_tagihan' => $arr->jenis_tagihan,
        'idtagihan' => $arr->idtagihan,
        'nomor_va' => $arr->nomor_va,
        'idtagihan_name' => $arr->idtagihan_name,
        'jatuh_tempo' => $arr->jatuh_tempo,
        'tagihan' => $arr->tagihan,
        'admin_bank' => $arr->admin_bank,
        'payment' => $arr->payment,
        'open_payment' => $arr->open_payment
    );
} else {
    $error->tagihanTidakDitemukan($saldo_member);
}

$reply = json_encode($response);
