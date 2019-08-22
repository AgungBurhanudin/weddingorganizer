<?php

$noid_add = strtoupper($jreq->detail->noid);
$produk_asli = $jreq->detail->produk;
$produk_add = str_replace('-', '', strtoupper($produk_asli));
$new_fee_add = strtoupper($jreq->detail->new_fee);

$sql_cek = "select id,noid,noid_act,noid_mit,tipe,jenis,noid_submit,fee from tbl_member_account where noid = '$noid_add';";

$arr_cek = $db->singleRow($sql_cek);
$tipe_add = $arr_cek->tipe;
if (isset($arr_cek->id)) {
    if ($tipe_member . $tipe_add == 'M1M2' || $tipe_member . $tipe_add == 'M2M3' || $jenis_member . $tipe_add == '2M1') {
        $arr_fee = json_decode($arr_cek->fee);
        $arr_fee->{$produk_add} = $new_fee_add;
        $new_fee = json_encode($arr_fee);
        $sql_update = "update tbl_member_account set fee = '$new_fee' where noid = '$noid_add';";
        $db->singleRow($sql_update);
        $response = array(
            'response_code' => '0000',
            'response_message' => "Update fee NOID $noid_add $produk_asli Rp. $new_fee_add",
            'saldo' => $saldo_member
        );
    } else {
        $error->accountTidakValid($saldo_member);
    }
} else {
    $error->accountTidakAda($saldo_member);
}
$reply = json_encode($response);
