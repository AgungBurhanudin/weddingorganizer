<?php

$id_add = strtoupper(trim($jreq->detail->id));
$arr = $db->singleRow("select id,nama,jenis,alamat from tbl_group_kolektif where id = $id_add");

if (isset($arr->id)) {
    $response = array(
        'response_code' => '0000',
        'response_message' => 'CEK DATA GROUP KOLEKTIF BERHASIL',
        'nama' => $arr->nama,
        'jenis' => $arr->jenis,
        'alamat' => $arr->alamat,
        'id' => $arr->id
    );
} else {
    $error->dataTidakAda($saldo_member);
}

$reply = json_encode($response);
