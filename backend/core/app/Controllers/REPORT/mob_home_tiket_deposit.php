<?php

$sql_cek_tiket = "select to_char(waktu,'DD-MM-YYYY HH24:MI') as waktu, bank,"
        . "nominal, status "
        . "from log_konfirmasi_topup where noid='$noid' order by waktu desc limit 10;";
$arr_cek = $db->multipleRow($sql_cek_tiket);

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr_cek;

$reply = json_encode($response);