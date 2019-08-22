<?php

$id_act = strtoupper(trim($jreq->detail->id));
$alias_act = strtoupper(trim($jreq->detail->alias_act));
$setting_card = strtoupper(trim($jreq->detail->setting_card));

$arr = $db->cekIdAct($id_act);
if (isset($arr->id)) {

    $sql = "BEGIN TRANSACTION;"
            . "update tbl_act_card set alias_act = '$alias_act', setting_card = $setting_card "
            . "where id = $id_act;"
            . "COMMIT;";
    $db->singleRow($sql);

    $response = array(
        'response_code' => '0000',
        'response_message' => 'UPDATE DATA BERHASIL'
    );
} else {
    $error->dataTidakAda($saldo_member);
}

$reply = json_encode($response);
