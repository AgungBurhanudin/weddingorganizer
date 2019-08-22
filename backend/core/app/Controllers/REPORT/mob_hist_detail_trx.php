<?php

$wh = '';
if (isset($jreq->search)) {
    if (trim($jreq->search) != '') {
        $searchnya = strtoupper($jreq->search);
        $wh = "and (detail::jsonb->>'idpel' like upper('%$searchnya%') or detail::jsonb->>'idpel_name' like upper('%$searchnya%'))";
    }
}

$sql_cek_nfc = "select to_char(waktu,'DD-MM-YYYY HH24:MI') as waktu, "
        . "concat(detail::jsonb->>'product', ' ', detail::jsonb->>'product_detail') as produk, "
        . "detail::jsonb->>'idpel' as idpel, detail::jsonb->>'idpel_name' as idpel_name, "
        . "amount as jml, amount, saldo,"
        . "CASE WHEN stat=0 THEN 'INQUIRY' "
        . "WHEN stat=1 THEN 'SUKSES' "
        . "WHEN stat=2 THEN 'GAGAL' "
        . "WHEN stat=3 THEN 'PENDING' "
        . "ELSE 'REFUND' END as status, "
        . "detail::jsonb->>'reff' as trace_id "
        . "from log_data_trx where noid='$noid' $wh order by id desc limit 50;";
$arr_cek = $db->multipleRow($sql_cek_nfc);

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr_cek;

$reply = json_encode($response);
