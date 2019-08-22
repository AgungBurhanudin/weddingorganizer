<?php

$dest_add = strtoupper($jreq->detail->alias);
$arr = $db->cekAliasChannel($dest_add);
if (isset($arr->id)) {
    $response = array(
        'response_code' => '0000',
        'response_message' => 'CEK DATA MEMBER CHANNEL BERHASIL',
        'id' => $arr->id,
        'interface' => $arr->interface,
        'noid' => $arr->noid,
        'alias' => $arr->alias,
        'nama' => $arr->nama,
        'email' => $arr->email,
        'limit_trx' => $arr->limit_trx,
        'today_trx' => $arr->today_trx,
        "photo" => $arr->photo_identity
    );
} else {
    $response = array(
        'response_code' => '0501', 
        'response_message' => 'ACCOUNT '.$dest_add.' TIDAK DITEMUKAN', 
        'saldo' => $saldo_member);
}

$reply = json_encode($response);
