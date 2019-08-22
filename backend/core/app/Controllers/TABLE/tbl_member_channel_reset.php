<?php

$id_add = strtoupper(trim($jreq->detail->id));
$arr = $db->cekIdChannel($id_add);
$interface_add = $arr->interface;
$ip_add = '';

if ($interface_add == 'WEB') {
    $alias_add = $arr->alias;
    $noid_add = $arr->noid;
    $passw_add = $fungsi->randomString(6);
    $limit_trx_add = 0;
    $msg_out = "Reset Akun $interface_add " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
            . "Website " . $konfig->urlWebLogin() . " USERNAME=$alias_add PASSWORD=$passw_add";
} else {
    $error->resetPasswordGagal($saldo_member);
}

if ($jenis_member == '2' || $noid_add == $noid) {
    $sql = "BEGIN TRANSACTION;"
            . "update tbl_member_channel set passw='$passw_add',status=1,"
            . "limit_trx=$limit_trx_add, salah_pin = 0 "
            . "where id = $id_add;"
            . "COMMIT;";

    $db->singleRow($sql);
    $db->kirimMessage($noid_add, $msg_out);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Reset Password $interface_add $alias_add",
        'saldo' => $saldo_member
    );
} else {
    $error->globalTidakBerhak($saldo_member);
}

$reply = json_encode($response);
