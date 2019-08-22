<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$tanggal = strtoupper($jreq->detail->tanggal); 
$product = strtoupper($jreq->detail->product); 


if ($tipe_member == 'M1') {
    $selfee = "jfee->>'fm1' as fee_m1, jfee->>'fm2' as fee_m2, jfee->>'fm3' as fee_m3";
    $def_noid = substr($noid, 0,3);
    $filter_def_noid = "and substring(noid from 1 for 3) = '$def_noid'";
} elseif ($tipe_member == 'M2') {
    $selfee = "jfee->>'fm2' as fee_m2, jfee->>'fm3' as fee_m3";
    $def_noid = substr($noid, 0,7);
    $filter_def_noid = "and substring(noid from 1 for 7) = '$def_noid'";
} elseif ($tipe_member == 'M3') {
    $selfee = "jfee->>'fm3' as fee_m3";
    $filter_def_noid = "and noid = '$noid'";
} else {
    $selfee = "jfee->>'fm1' as fee_m1, jfee->>'fm2' as fee_m2, jfee->>'fm3' as fee_m3";
    $filter_def_noid = '';
}


$sql = "select to_char(waktu,'YYYY-MM-DD HH24:MI:SS')as time, concat(detail->>'product',' ',detail->>'product_detail') as product, "
        . "detail->>'idpel' as idpel, detail->>'idpel_name' as nama, detail->>'lembar' as lembar, "
        . "detail->>'tagihan' as tagihan, detail->>'admin_bank' as admin, detail->>'total_tagihan' as total_tagihan, "
        . "$selfee "
        . "from log_data_trx where response_code='0000' "
        . "$filter_def_noid and detail::jsonb->>'product_detail' != 'SALDO' and "
        . "to_char(waktu,'YYYY-MM-DD')='$tanggal' and concat(detail->>'product',' ',detail->>'product_detail') = '$product' order by id asc";

$arr = $db->multipleRow($sql);

if (isset($arr[0]->time)) {
    $reply = json_encode($arr);
} else {
    $reply = '[]';
}