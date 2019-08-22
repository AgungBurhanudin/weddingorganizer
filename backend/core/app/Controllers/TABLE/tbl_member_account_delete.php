<?php

$noid_add = strtoupper(trim($jreq->detail->noid));
$arr = $db->cekNoidMember($noid_add);
if (isset($arr->id)) {
    $jenis_add = $arr->jenis;
    //kirim message
    if ($arr->saldo == 0) {
        $msg_out = "Akun $noid_add a.n $arr->nama TELAH DIHAPUS";
        $db->kirimMessage($noid_add,$msg_out);
        $sql = "BEGIN TRANSACTION;"
                . "delete from tbl_member_channel where noid = '$noid_add';"
                . "update tbl_member_account set nohp_email = 'DELETE $ref', status = 0, jenis = 0 where noid = '$noid_add';"
                . "COMMIT;";
        $db->singleRow($sql);

        $response = array(
            'response_code' => '0000',
            'response_message' => 'DELETE DATA BERHASIL',
            'saldo' => $saldo_member
        );
    } else {
        $error->globalTidakBerhak($saldo_member);
    }
} else {
    $error->accountTidakAda($saldo_member);
}
$reply = json_encode($response);
