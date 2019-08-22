<?php

$id_add = strtoupper($jreq->detail->id);

$sql_cek = "select id from log_message where id = $id_add;";

$arr_cek = $db->singleRow($sql_cek);

if (isset($arr_cek->id)) {
    $sql_delete = "delete from log_message where id = $id_add;";
    $db->singleRow($sql_delete);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Hapus Pesan Berhasil.",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);
