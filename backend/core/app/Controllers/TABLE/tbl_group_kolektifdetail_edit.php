<?php
$idgroup_add = strtoupper(trim($jreq->detail->id_group));
$id_add = strtoupper(trim($jreq->detail->id));
$idpel_add = strtoupper(trim($jreq->detail->idpel_new));

$arr = $db->cekDetailKolektif($idgroup_add,$idpel_add);
if (isset($arr->id)) {
    $error->idpelKolektifTerdaftar($saldo_member);
}
$arr_cek = $db->singleRow("select id,idpel from tbl_group_kolektif_detail where id = $id_add and id_group = $idgroup_add;");

if (isset($arr_cek->id)) {
    $idpel = $arr_cek->idpel;
    $sql = "BEGIN TRANSACTION;"
            . "update tbl_group_kolektif_detail set idpel='$idpel_add',status=0,"
            . "idpel_name='',tagihan=0,admin_bank=0,total_tagihan=0,bulan=0,"
            . "keterangan='',last_update=now() where id = $id_add;"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Update Detail Kolektif $idpel menjadi $idpel_add",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

