<?php

$sql_cek_nfc = "select to_char(waktu,'DD-MM-YYYY HH24:MI') as waktu, "
        . "regexp_replace(msg,'=......','=XXXXXX','g') as msg "
        . "from log_message where noid='$noid' order by waktu desc limit 50;";
$arr_cek = $db->multipleRow($sql_cek_nfc);

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr_cek;

$reply = json_encode($response);