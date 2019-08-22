<?php

//every 1 minute
$username = $nohp_email;
$noid = $jreq->noid;
$arr_mbch = $db->cekAliasChannel($username);
$last_seen = $arr_mbch->last_message;
$sql_cek = "select count(id) as jumlah from log_message where noid = '$noid' and waktu > '$last_seen';";
$arr = $db->singleRow($sql_cek);

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr;

$reply = json_encode($response);
