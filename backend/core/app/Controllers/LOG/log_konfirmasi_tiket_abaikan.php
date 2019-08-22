<?php

$id_add = $jreq->detail->id;
$sql_cek_konf = "select * from log_konfirmasi_topup where id = $id_add and status = 0;";
$arr_cek_konf = $db->singleRow($sql_cek_konf);

if (isset($arr_cek_konf->id)) {

    $amount_add = $arr_cek_konf->nominal;
    $noid_add = $arr_cek_konf->noid;

    $sql_konf_abaikan = "update log_konfirmasi_topup set status=-1,noid_executor = '$noid',waktu_proses=now() "
            . "where id = $id_add ";
    $db->singleRow($sql_konf_abaikan);

    $response = array(
        'response_code' => '0000',
        'response_message' => "Tiket Deposit Saldo Member ID $noid_add Nominal $amount_add diabaikan",
        'saldo' => $saldo_member
    );
} else {
    $response = array(
        'response_code' => '0403',
        'response_message' => "Proses Abaikan Tiket Deposit Saldo GAGAL, Data tidak ditemukan",
        'saldo' => $saldo_member
    );
}

$reply = json_encode($response);
