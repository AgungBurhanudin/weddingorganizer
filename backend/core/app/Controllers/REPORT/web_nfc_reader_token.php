<?php

$sql_cek = "select alias,token from tbl_member_channel where alias = '$username';";
$arr_cek = $db->singleRow($sql_cek);
if (isset($arr_cek->alias)) {
    $alias = $arr_cek->alias;
    $token = $arr_cek->token;
    $device_reader = substr($alias, 0,5).substr($token, 0,5);
    $response = array(
        'response_code' => '0000',
        'response_message' => 'ID Device Reader Anda : '.$device_reader,
        'saldo' => $fungsi->rupiah($saldo_member)
    );
} else {
    $error->accountTidakAda($saldo_member);
}


$reply = json_encode($response);
