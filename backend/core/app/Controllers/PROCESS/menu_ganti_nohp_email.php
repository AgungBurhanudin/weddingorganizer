<?php

$noid_add = strtoupper($jreq->detail->noid);
$nohp_old = strtoupper($jreq->detail->nohp_old);
$nohp_new = strtoupper($jreq->detail->nohp_new);

$sql_cek = "select * from tbl_member_account where status = 1 and nohp_email = '$nohp_old' and noid = '$noid_add';";
$sql_update = "update tbl_member_account set nohp_email = '$nohp_new' where nohp_email = '$nohp_old' and noid = '$noid_add';"
        . "update tbl_member_channel set alias = '$nohp_new' where alias = '$nohp_old' and noid = '$noid_add';"
        . "update tbl_member_channel set email = '$nohp_new' where email = '$nohp_old' and noid = '$noid_add';";

$arr_cek = $db->singleRow($sql_cek);

if (isset($arr_cek->id)) {
                $db->singleRow($sql_update);
                $response = array(
                    'response_code' => '0000',
                    'response_message' => "Perubahan Nohp / Email NOID $noid_add menjadi $nohp_new BERHASIL",
                    'saldo' => $saldo_member
                );
                $db->kirimMessageUnreg($nohp_old,$konfig->namaAplikasi().', NOHP / EMAIL anda telah diubah.');

}else{
    $error->accountTidakAda($saldo_member);
}
$reply = json_encode($response);
