<?php

$sql_cek_nfc = "select id,waktu::timestamp(0) as waktu,interface,noid,alias,bank,norek_tujuan,nominal,status,keterangan,reff,"
        . "waktu_proses,noid_executor,bukti_transfer from log_konfirmasi_topup "
        . "where noid='$noid' and (status =1 or date(waktu) = date(now())) order by id desc limit 15;";
$arr_cek = $db->multipleRow($sql_cek_nfc);

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr_cek;

$reply = json_encode($response);