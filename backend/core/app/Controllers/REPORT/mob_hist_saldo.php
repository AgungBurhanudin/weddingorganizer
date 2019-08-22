<?php

$wh = '';
if (isset($jreq->search)) {
    if (trim($jreq->search) != '') {
        $wh = "and detail::jsonb->>'idpel_name' like upper('%$jreq->search%')";
    }
}

$sql_cek_nfc = "select to_char(waktu,'DD-MM-YYYY HH24:MI') as waktu, "
        . "concat(detail::jsonb->>'product', ' ', detail::jsonb->>'product_detail') as produk, "
        . "amount as jml, saldo from log_data_trx where detail::jsonb->>'product_detail' = 'SALDO' and noid='$noid' $wh order by id desc limit 20;";
$arr_cek = $db->multipleRow($sql_cek_nfc);

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr_cek;

$reply = json_encode($response);
