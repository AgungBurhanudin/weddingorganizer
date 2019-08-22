<?php

$id_add = strtoupper($jreq->detail->id);

$sql_cek = "select id from log_message where id = $id_add;";

$arr_cek = $db->singleRow($sql_cek);

if (isset($arr_cek->id)) {
    $sql_delete = "update log_message set stat = 0, resend = resend + 1 where id = $arr_cek->id;";
    $db->singleRow($sql_delete);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Kirim ulang message berhasil",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);
