<?php

$id_add = strtoupper(trim($jreq->detail->id));
$arr = $db->singleRow("select id,idpel,idpel_name,tagihan,admin_bank,total_tagihan,bulan,keterangan,last_update::timestamp(0) "
        . "from tbl_group_kolektif_detail where id = $id_add");

if (isset($arr->id)) {
    $response = array(
        'response_code' => '0000',
        'response_message' => 'CEK DATA DETAIL KOLEKTIF BERHASIL',
        'id' => $arr->id,
        'idpel' => $arr->idpel,
        'idpel_name' => $arr->idpel_name,
        'tagihan' => $arr->tagihan,
        'admin_bank' => $arr->admin_bank,
        'total_tagihan' => $arr->total_tagihan,
        'bulan' => $arr->bulan,
        'keterangan' => $arr->keterangan,
        'last_update' => $arr->last_update
    );
} else {
    $error->dataTidakAda($saldo_member);
}

$reply = json_encode($response);
