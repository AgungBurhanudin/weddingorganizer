<?php

$noid_add = strtoupper($jreq->detail->noid);
$new_setting_fee = strtoupper($jreq->detail->new_setting_ca); // 0=CA KORWIL, 1=SubCA

$sql_cek = "select id,noid,noid_act,noid_mit,tipe,jenis,noid_submit,fee from tbl_member_account where noid = '$noid_add';";

$arr_cek = $db->singleRow($sql_cek);
$tipe_add = $arr_cek->tipe;
if (isset($arr_cek->id)) {
    if ($tipe_member . $tipe_add == 'ADMINM1') {
        $sql_update = "update tbl_member_account set hak_saldo = '$new_setting_fee' where noid = '$noid_add';";
        $db->singleRow($sql_update);
        $new_setting = ($new_setting_fee == 0) ? 'CA KORWIL' : 'CA';
        $response = array(
            'response_code' => '0000',
            'response_message' => "Update Setting M1 NOID $noid_add sebagai $new_setting Berhasil",
            'saldo' => $saldo_member
        );
    } else {
        $error->accountTidakValid($saldo_member);
    }
} else {
    $error->accountTidakAda($saldo_member);
}
$reply = json_encode($response);
