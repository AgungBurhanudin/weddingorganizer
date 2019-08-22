<?php

$old_password_add = strtoupper($jreq->detail->old_password);
$new_password1_add = strtoupper($jreq->detail->new_password1);
$new_password2_add = strtoupper($jreq->detail->new_password2);

$sql_cek = "select passw from tbl_member_channel where status = 1 and noid = '$noid' and alias = '$username' and interface = '$interface';";
$sql_update = "update tbl_member_channel set passw = '$new_password1_add' where noid = '$noid' and alias = '$username' and interface = '$interface';";

$arr_cek = $db->singleRow($sql_cek);

if (isset($arr_cek->passw)) {
    $_password_lama = $arr_cek->passw;
    if ($old_password_add == $_password_lama) {
        if ($new_password1_add == $new_password2_add) {
            if (!preg_match("/[^a-zA-Z0-9]/", $new_password1_add)) {
                $db->singleRow($sql_update);
                $response = array(
                    'response_code' => '0000',
                    'response_message' => 'Perubahan PASSWORD Berhasil, Jaga kerahasiaan PASSWORD Anda.',
                    'saldo' => $saldo_member
                );
                $db->kirimMessage($noid,$konfig->namaAplikasi().', Anda Telah Melakukan Perubahan PASSWORD, Jaga kerahasiaan PASSWORD Anda.');
            } else {
                $error->gantiPasswordTidakValid($saldo_member);
            }
        } else {
            //_password baru tidak sama
            $error->gantiPasswordBaruTidakSama($saldo_member);
        }
    } else {
        //salah _password lama
        $error->gantiPasswordLamaTidakSama($saldo_member);
    }
}else{
    $error->accountTidakAda($saldo_member);
}
$reply = json_encode($response);
