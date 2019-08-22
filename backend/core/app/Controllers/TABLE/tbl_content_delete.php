<?php

$id_add = strtoupper(trim($jreq->detail->id));

$arr_cek = $db->singleRow("select id,title from tbl_contents where id = $id_add");

if (isset($arr_cek->id)) {
    $title = $arr_cek->title;
    $sql = "BEGIN TRANSACTION;"
            . "delete from tbl_contents where id = $id_add;"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses HAPUS Konten $title",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

