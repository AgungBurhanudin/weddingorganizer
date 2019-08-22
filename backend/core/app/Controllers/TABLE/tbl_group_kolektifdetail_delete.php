<?php

$id_add = strtoupper(trim($jreq->detail->id));

$arr_cek = $db->singleRow("select id,idpel from tbl_group_kolektif_detail where id = $id_add");

if (isset($arr_cek->id)) {
    $idpel = $arr_cek->idpel;
    
    $sql = "BEGIN TRANSACTION;"
            . "delete from tbl_group_kolektif_detail where id = $id_add;"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses HAPUS Detail Kolektif $idpel",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

