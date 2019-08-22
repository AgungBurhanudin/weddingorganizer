<?php

$arr_mbch = $db->cekAliasChannel($username);
$last_seen = $arr_mbch->last_message;

$sql_cek_nfc = "select id,to_char(waktu,'DD-MM-YYYY HH24:MI') as waktu, "
        . "regexp_replace(msg,'=......','=XXXXXX','g') as msg, "
        . "case when waktu < '$last_seen' then 1 else 0 end as dibaca "
        . "from log_message where noid='$noid' order by waktu desc limit 50;";
$arr_cek = $db->multipleRow($sql_cek_nfc);

//update last message inbox
$sql_update_last_msg = "update tbl_member_channel set last_message = now() "
        . "where noid = '$noid' and alias = '$username';";
$db->singleRow($sql_update_last_msg);

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr_cek;

$reply = json_encode($response);