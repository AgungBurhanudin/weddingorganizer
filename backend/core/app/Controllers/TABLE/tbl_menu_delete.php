<?php

$id_add = strtoupper(trim($jreq->detail->id));

$arr_cek = $db->singleRow("select id,perintah from tbl_menu where id = $id_add");

if (isset($arr_cek->id)) {
    $perintah = $arr_cek->perintah;
    $sql = "BEGIN TRANSACTION;"
            . "DELETE FROM tbl_menu WHERE id = $id_add;"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Hapus Perintah $perintah",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

