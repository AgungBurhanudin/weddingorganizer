<?php

$idgroup_add = strtoupper(trim($jreq->detail->id_group));
$idpel_add = strtoupper(trim($jreq->detail->idpel));

$arr_cek = $db->cekDetailKolektif($idgroup_add,$idpel_add);

if (!isset($arr_cek->id)) {
    $sql = "BEGIN TRANSACTION;"
            . "insert into tbl_group_kolektif_detail (id_group,idpel) values"
            . "('$idgroup_add','$idpel_add');"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Penambahan Detail Kolektif $idpel_add",
        'saldo' => $saldo_member
    );
} else {
    $error->idpelKolektifTerdaftar($saldo_member);
}
$reply = json_encode($response);
