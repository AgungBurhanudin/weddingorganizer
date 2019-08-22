<?php

$id_add = strtoupper(trim($jreq->detail->id));
$alias_act = strtoupper(trim($jreq->detail->alias_act));
$setting_card = strtoupper(trim($jreq->detail->setting_card));

$arr_cek = $db->singleRow("select id,noid,alias_act from tbl_act_card where id = $id_add");

if (isset($arr_cek->id)) {
    $nama = $arr_cek->alias_act;
    $sql = "BEGIN TRANSACTION;"
            . "update tbl_act_card set alias_act='$alias_act', setting_card='$setting_card' where id = $id_add;"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Update Setting Aktivasi $nama menjadi $alias_act",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

