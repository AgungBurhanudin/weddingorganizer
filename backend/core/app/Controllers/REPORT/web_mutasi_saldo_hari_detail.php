<?php

$tanggal = strtoupper($jreq->detail->tanggal);
$q = array();
$s = $db->multipleRow("select id,to_char(waktu,'YYYY-MM-DD HH24:MI:SS')as time, "
        . "detail->>'product' as product,detail->>'product_detail' as product_detail, detail->>'idpel' as idpel, detail->>'idpel_name' as nama,"
        . "saldo-amount as balance_start, amount, saldo as balance_end "
        . "from log_data_trx where is_flexible = 0 AND to_char(waktu,'YYYY-MM-DD')='$tanggal' and noid='$noid'");

if ($s != false) {
    foreach ($s as $data) {
        $q[] = json_decode('{"time": "' . $data->time . '", "balance_start": "' . $data->balance_start . '", "amount": "' . $data->amount . '", "balance_end": "' . $data->balance_end . '", "product": "' . $data->product . '", "idpel": "' . $data->idpel . '", "nama": "' . $data->nama . '"}');
    }
}

$reply = json_encode($q);

