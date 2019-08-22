<?php

/*
  {
  "detail": {
  "interface": "WEB/NFC/H2H",
  "noid": "000000000000000",
  "nama": "MIZA ZAKI"
  "alias": "NFC_ID",
  "passw": "123456",
  "limit_trx": "20000"

  }
  }:
 */

$interface_add = strtoupper(trim($jreq->detail->interface));
$ip_add = '';

if ($interface_add == 'NFC') {
    $noid_add = strtoupper(trim($jreq->detail->noid));
    $nama_add = strtoupper(trim($jreq->detail->nama));
    $alias_add = strtoupper(trim($jreq->detail->alias));
    $passw_add = strtoupper(trim($jreq->detail->passw));
    $limit_trx_add = trim($jreq->detail->limit_trx);
    $msg_out = "Registrasi Kartu NFC " . $konfig->namaAplikasi() . " telah berhasil. UID:$alias_add a.n $nama_add "
            . "PIN Transaksi=$passw_add dengan limit transaksi per hari $limit_trx_add";
    if (($noid_add == $noid) || (substr($noid_add, 0, 7) == substr($noid, 0, 7) && $tipe_member == 'M2')) {

    } else {
        $error->regAccountTidakBerhak($saldo_member);
    }
    $nohp_email_member = '';
} elseif ($interface_add == 'WEB') {
    $noid_add = $noid;
    $nama_add = strtoupper(trim($jreq->detail->nama));
    $alias_add = substr(str_replace(' ', '', $nama_add), 0, 6) . $fungsi->randomNumber(4);
    $passw_add = $fungsi->randomString(6);
    $limit_trx_add = 0;
    $msg_out = "Registrasi Akun $interface_add " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
            . "Website " . $konfig->urlWebLogin() . " USERNAME=$alias_add PASSWORD=$passw_add";
} elseif ($interface_add == 'H2H') {
    $noid_add = $noid;
    $nama_add = strtoupper(trim($jreq->detail->nama));
    $ip_add = strtoupper(trim($jreq->detail->ip));
    $alias_add = substr(str_replace(' ', '', $nama_add), 0, 6) . $fungsi->randomNumber(4);
    $passw_add = $fungsi->randomString(6);
    $limit_trx_add = 0;
    $token_add = $fungsi->randomString(20);
    $appid_add = $fungsi->randomString(20);
    $msg_out = "Registrasi Akun $interface_add " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
            . "CREDENTIAL H2H USERNAME=$alias_add TOKEN=$token_add APPID=$appid_add";
} elseif ($interface_add == 'PINPAY') {
    $noid_add = $noid;
    $nama_add = strtoupper(trim($jreq->detail->nama));
    $alias_add = $fungsi->randomString(3).$fungsi->randomNumber(3);
    $passw_add = $fungsi->randomString(6);
    $limit_trx_add = trim($jreq->detail->limit_trx);
    $msg_out = "Registrasi Akun $interface_add " . $konfig->namaAplikasi() . " telah berhasil. PINPAY=$alias_add a.n $nama_add "
            . "PIN Transaksi=$passw_add dengan limit transaksi per hari $limit_trx_add";
} else {
    //die;
}

$arr_cek_alias = $db->cekAliasChannel($alias_add);

if (!isset($arr_cek_alias->id)) {

    $sql = "BEGIN TRANSACTION;"
            . "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,limit_trx) values "
            . "('$interface_add','$noid_add','$alias_add',now(),now(),'$passw_add','$nama_add','$nohp_email_member',$limit_trx_add);"
            . "COMMIT;";

    $db->singleRow($sql);
    $db->kirimMessage($noid_add,$msg_out);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Registrasi $interface_add $nama_add"
    );
} else {
    $error->regAccountAliasTerdaftar($saldo_member);
}

$reply = json_encode($response);
