<?php

$id_add = strtoupper(trim($jreq->detail->id));
$arr = $db->singleRow("select id,noid,alias_act,setting_card from tbl_act_card where id = $id_add");

if (isset($arr->id)) {
    $response = array(
        'response_code' => '0000',
        'response_message' => 'CEK SETTING AKTIVASI BERHASIL',
        'noid' => $arr->noid,
        'alias_act' => $arr->alias_act,
        'setting_card' => $arr->setting_card,
        'id' => $arr->id
    );
} else {
    $error->dataTidakAda($saldo_member);
}

$reply = json_encode($response);
