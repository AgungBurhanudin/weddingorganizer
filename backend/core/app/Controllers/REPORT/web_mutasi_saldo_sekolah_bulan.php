<?php

$bl = strtoupper($jreq->detail->bulan);
$th = strtoupper($jreq->detail->tahun);

$lastday = date('t', mktime(0, 0, 0, $bl, 1, $th));
$q = array();
for ($i = 1; $i <= $lastday; $i++) {
    $hr = '0' . $i;
    $hr = substr($hr, strlen($hr) - 2, 2);
    if ("{$th}-{$bl}-{$hr}" > date('Y-m-d')) {
        break;
    }

    $s = $db->singleRow("select saldo from log_data_trx where is_flexible = 1 AND noid='$noid' and to_char(waktu,'YYYY-MM-DD')<'$th-$bl-$hr' order by id desc limit 1 ");
    $saldo = (!$s) ? 0 : $s->saldo;
    $q[] = json_decode('{"date": "' . "{$hr}-{$bl}-{$th}" . '", "balance":"' . $saldo . '"}');
}

$reply = json_encode($q);