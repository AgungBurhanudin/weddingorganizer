<?php

$bulantahun = isset($jreq->bulantahun) ? "'$jreq->bulantahun'" : "to_char(now(),'MMYYYY')";

$sql_cek_nfc = "select to_char(waktu,'DD') as tanggal , "
        . "concat(detail::jsonb->>'product',' ',detail::jsonb->>'product_detail') as produk, "
        . "count(id) as total, sum(amount) as nominal "
        . "from log_data_trx where noid='$noid' and to_char(waktu,'MMYYYY') = $bulantahun "
        . "group by to_char(waktu,'DD'),concat(detail::jsonb->>'product',' ',detail::jsonb->>'product_detail') "
        . "order by tanggal,produk;";
$arr_cek = $db->multipleRow($sql_cek_nfc);

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr_cek;

$reply = json_encode($response);
