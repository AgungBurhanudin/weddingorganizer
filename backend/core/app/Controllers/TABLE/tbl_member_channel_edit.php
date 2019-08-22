<?php

/*
  {
  "detail": {
  "id": 29,
  "nama": "MIZA ZAKI"
  "alias": "NFC_ID",
  "passw": "123456",
  "limit_trx": "20000"
  
  }
  }:
 */

$id_add = strtoupper(trim($jreq->detail->id));
$arr = $db->cekIdChannel($id_add);
$interface_add = $arr->interface;
$ip_add = '';

if ($interface_add == 'NFC') {
    $noid_add = $arr->noid;
    $nama_add = strtoupper(trim($jreq->detail->nama));
    $alias_add = strtoupper(trim($jreq->detail->alias));
    if(isset($jreq->detail->passw)){
        if(strlen($jreq->detail->passw) < 6){
            $error->passwordMinimal($saldo_member);
        }
        $passw_add = trim($jreq->detail->passw);
        $pass_update = ",passw='$passw_add'";
        $pass_notif = "PIN Transaksi=$passw_add";
    }else{
        $pass_update = "";
        $pass_notif = "";
    }
    $limit_trx_add = trim($jreq->detail->limit_trx);
    $msg_out = "Update Kartu NFC " . $konfig->namaAplikasi() . " telah berhasil. UID:$alias_add a.n $nama_add "
            . "$pass_notif dengan limit transaksi per hari $limit_trx_add";
    if (($noid_add == $noid) || (substr($noid_add,0,7) == substr($noid,0,7) && $tipe_member == 'M2')) {
    
    } else {
        $error->regAccountTidakBerhak($saldo_member);
    }
    $nohp_email_member = '';
} elseif ($interface_add == 'WEB') {
    $nama_add = strtoupper(trim($jreq->detail->nama));
    $alias_add = substr(str_replace(' ', '', $nama_add), 0, 6) . $fungsi->randomNumber(4);
    $passw_add = $fungsi->randomString(6);
    $pass_update = ",passw='$passw_add'";
    $limit_trx_add = 0;
    $msg_out = "Update Akun $interface_add " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
            . "Website " . $konfig->urlWebLogin() . " USERNAME=$alias_add PASSWORD=$passw_add";
} elseif ($interface_add == 'H2H') {
    $nama_add = strtoupper(trim($jreq->detail->nama));
    $ip_add = strtoupper(trim($jreq->detail->ip));
    $alias_add = substr(str_replace(' ', '', $nama_add), 0, 6) . $fungsi->randomNumber(4);
    $passw_add = $fungsi->randomString(6);
    $pass_update = ",passw='$passw_add'";
    $limit_trx_add = 0;
    $token_add = $fungsi->randomString(20);
    $appid_add = $fungsi->randomString(20);
    $msg_out = "Update Akun $interface_add " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
            . "CREDENTIAL H2H USERNAME=$alias_add TOKEN=$token_add APPID=$appid_add";
} elseif ($interface_add == 'PINPAY') {
    $nama_add = strtoupper(trim($jreq->detail->nama));
    $alias_add = $fungsi->randomString(3).$fungsi->randomNumber(3);
    $passw_add = $fungsi->randomString(6);
    $pass_update = ",passw='$passw_add'";
    $limit_trx_add = trim($jreq->detail->limit_trx);
    $msg_out = "Update Akun $interface_add " . $konfig->namaAplikasi() . " telah berhasil. PINPAY=$alias_add a.n $nama_add "
            . "PIN Transaksi=$passw_add dengan limit transaksi per hari $limit_trx_add";
} else {
    //die;
}

if (!isset($arr_cek_alias->id)) {
    if ($jenis_member == '2' || $noid_add == $noid || $interface_add == 'NFC') {
    $sql = "BEGIN TRANSACTION;"
            . "update tbl_member_channel set alias='$alias_add' $pass_update ,nama='$nama_add',status=1,"
            . "limit_trx=$limit_trx_add "
            . "where id = $id_add;"
            . "COMMIT;";

    $db->singleRow($sql);
    $db->kirimMessage($noid_add,$msg_out);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Update $interface_add $nama_add",
        'saldo' => $saldo_member
    );
    }else{
        $error->globalTidakBerhak($saldo_member);
    }
} else {
    $error->regAccountAliasTerdaftar($saldo_member);
}

$reply = json_encode($response);
