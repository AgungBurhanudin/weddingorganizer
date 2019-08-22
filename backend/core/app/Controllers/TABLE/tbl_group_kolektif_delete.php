<?php

$id_add = strtoupper(trim($jreq->detail->id));

$arr_cek = $db->singleRow("select id,nama,jenis from tbl_group_kolektif where id = $id_add");

if (isset($arr_cek->id)) {
    $nama = $arr_cek->nama;
    $jenis = $arr_cek->jenis;
    $sql = "BEGIN TRANSACTION;"
            . "delete from tbl_group_kolektif where id = $id_add;"
            . "delete from tbl_group_kolektif_detail where id_group = $id_add;"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses HAPUS Group Kolektif $nama $jenis",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

