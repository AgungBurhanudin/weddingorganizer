<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$bulan = strtoupper($jreq->detail->bulan);
$tahun = strtoupper($jreq->detail->tahun);
$filter_jenis_saldo    = isset($jreq->detail->saldo_tipe) ? "and is_flexible = '$jreq->detail->saldo_tipe'" : "";

if ($tipe_member == 'M1') {
    $selfee = "sum(cast(jfee->>'fm1' as integer)) as fee_m1, "
        . "sum(cast(jfee->>'fm2' as integer)) as fee_m2, "
        . "sum(cast(jfee->>'fm3' as integer)) as fee_m3,";
    $def_noid = substr($noid, 0,3);
    $filter_def_noid = "and substring(noid from 1 for 3) = '$def_noid'";
} elseif ($tipe_member == 'M2') {
    $selfee = "sum(cast(jfee->>'fm2' as integer)) as fee_m2, "
        . "sum(cast(jfee->>'fm3' as integer)) as fee_m3,";
    $def_noid = substr($noid, 0,7);
    $filter_def_noid = "and substring(noid from 1 for 7) = '$def_noid'";
} elseif ($tipe_member == 'M3') {
    $selfee = "sum(cast(jfee->>'fm3' as integer)) as fee_m3,";
    $filter_def_noid = "and noid = '$noid'";
} else {
    $selfee = "sum(cast(jfee->>'fm1' as integer)) as fee_m1, "
        . "sum(cast(jfee->>'fm2' as integer)) as fee_m2, "
        . "sum(cast(jfee->>'fm3' as integer)) as fee_m3,";
    $filter_def_noid = '';
}

$sql = "select to_char(waktu,'YYYY-MM-DD')as date, count(id)as jumlah,"
        . "sum(cast(detail->>'total_tagihan' as integer)) as total_tagihan,"
        . "sum(cast(detail->>'admin_bank' as integer)) as admin_bank,"
        . "$selfee "
        . "sum(cast(detail->>'tagihan' as integer)) as tagihan "
        . "from log_data_trx where response_code='0000' $filter_jenis_saldo "
        . "$filter_def_noid and detail::jsonb->>'product_detail' != 'SALDO' "
        . "and to_char(waktu,'YYYYMM')='$tahun$bulan' group by to_char(waktu,'YYYY-MM-DD') "
        . "order by to_char(waktu,'YYYY-MM-DD') asc";


$arr = $db->multipleRow($sql);

if (isset($arr[0]->date)) {
    $reply = json_encode($arr);
} else {
    $reply = '[]';
}