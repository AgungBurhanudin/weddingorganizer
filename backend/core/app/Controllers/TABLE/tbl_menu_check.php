<?php

$id_add = strtoupper(trim($jreq->detail->id));
$arr = $db->singleRow("select id,perintah,hak_akses,aturan,validasi,status,keterangan from tbl_menu where id = $id_add");

if (isset($arr->id)) {
    $response = array(
        'response_code' => '0000',
        'response_message' => 'CEK DATA MENU BERHASIL',
        'perintah' => $arr->perintah,
        'hak_akses' => $arr->hak_akses,
        'aturan' => $arr->aturan,
        'validasi' => $arr->validasi,
        'status' => $arr->status,
        'keterangan' => $arr->keterangan,
        'id' => $arr->id
    );
} else {
    $error->dataTidakAda($saldo_member);
}

$reply = json_encode($response);
