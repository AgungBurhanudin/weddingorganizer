<?php

//edit nama email
$id_add = strtoupper(trim($jreq->detail->id));

$arr = $db->cekIdChannel($id_add);

if (isset($arr->id)) {
    $noid_add = $arr->noid;

    if ($arr->status == 1) {
        $stat = 0;
        $action_add = 'BLOKIR';
    } else {
        $stat = 1;
        $action_add = 'BUKA BLOKIR';
    }

    $aturan = 1; //pegawai boleh edit semua nya, M1 edit downline, M2 edit downline, M3 edit diri sendiri
    if ($aturan == 1 ) {

        $sql = "BEGIN TRANSACTION;"
                . "update tbl_member_channel set status = $stat "
                . "where id = $id_add;"
                . "COMMIT;";
        $db->singleRow($sql);

        $response = array(
            'response_code' => '0000',
            'response_message' => "$action_add $noid_add BERHASIL",
            'saldo' => $saldo_member
        );
    } else {
        $error->regAccountTidakBerhak($saldo_member);
    }
} else {
    $error->accountTidakAda($saldo_member);
}

$reply = json_encode($response);
