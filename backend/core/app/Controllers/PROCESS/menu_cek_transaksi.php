<?php

$idpel = strtoupper($jreq->detail->idpel);

if ($tipe_member == 'M1') {
    $def_noid = substr($noid, 0,3);
    $filter_def_noid = "and substring(noid from 1 for 3) = '$def_noid'";
} elseif ($tipe_member == 'M2') {
    $filter_def_noid = "and substring(noid from 1 for 7) = '$def_noid'";
} elseif ($tipe_member == 'M3') {
    $filter_def_noid = "and noid = '$noid'";
} else {
    $filter_def_noid = '';
}

$sql = "select id,to_char(waktu,'YYYY-MM-DD HH24:MI:SS')as time,"
        . "noid,reff,"
        . "detail::jsonb->>'product' as product,"
        . "detail::jsonb->>'product_detail' as product_detail,"
        . "detail::jsonb->>'idpel' as idpel,"
        . "detail::jsonb->>'idpel_name' as idpel_name,"
        . "detail::jsonb->>'lembar' as lembar,"
        . "detail::jsonb->>'response_code' as response_code,"
        . "detail::jsonb->>'tagihan' as tagihan,"
        . "detail::jsonb->>'admin_bank' as admin_bank,"
        . "detail::jsonb->>'total_tagihan' as total_tagihan,"
        . "CASE WHEN stat=0 THEN 'INQUIRY' "
        . "WHEN stat=1 THEN 'SUKSES' "
        . "WHEN stat=2 THEN 'GAGAL' "
        . "WHEN stat=3 THEN 'PENDING' "
        . "ELSE 'REFUND' END as status "
        . "from log_data_trx where amount < 0 and (detail::jsonb->>'idpel' = '$idpel' or detail::jsonb->>'idpel_name' like '%$idpel%')"
        . " $filter_def_noid;";
$arr = $db->multipleRow($sql);

if (isset($arr[0]->id)) {
    $reply = json_encode($arr);
} else {
    $reply = '[]';
}
