<?php

$noid_add = strtoupper($jreq->detail->noid);
$new_setting_fee = strtoupper($jreq->detail->new_setting_korwil); // 0=KORWIL, 1=SubCA

$sql_cek = "select id,noid,noid_act,noid_mit,tipe,jenis,noid_submit,fee from tbl_member_account where noid = '$noid_add';";

$arr_cek = $db->singleRow($sql_cek);
$tipe_add = $arr_cek->tipe;
if (isset($arr_cek->id)) {
    if ($tipe_member . $tipe_add == 'M1M2' || $tipe_member . $tipe_add == 'ADMINM2') {
        $sql_update = "update tbl_member_account set hak_saldo = '$new_setting_fee' where noid = '$noid_add';";
        $db->singleRow($sql_update);
        $new_setting = ($new_setting_fee == 0) ? 'KORWIL' : 'SubCA';
        $response = array(
            'response_code' => '0000',
            'response_message' => "Update Setting M2 NOID $noid_add sebagai $new_setting Berhasil",
            'saldo' => $saldo_member
        );
    } else {
        $error->accountTidakValid($saldo_member);
    }
} else {
    $error->accountTidakAda($saldo_member);
}
$reply = json_encode($response);
