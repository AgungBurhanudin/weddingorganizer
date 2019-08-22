<?php

$sql_cek_nfc = "select id,alias as nfc_id, nama, passw, status, limit_trx, today_trx from tbl_member_channel "
        . "where noid = '$noid' and interface = 'NFC';";
$arr_cek = $db->multipleRow($sql_cek_nfc);

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr_cek;

$reply = json_encode($response);
