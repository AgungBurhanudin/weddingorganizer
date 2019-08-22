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
        . "noid,"
        . "struk::jsonb->>'idpel' as idpel,"
        . "struk::jsonb->>'nomor_meter' as nomor_meter,"
        . "struk::jsonb->>'nama' as idpel_name,"
        . "struk::jsonb->>'ref' as reff,"
        . "response_code,"
        . "struk::jsonb->>'admin' as admin_bank,"
        . "struk::jsonb->>'total' as total_tagihan,"
        . "struk::jsonb->>'stroom' as stroom, "
        . "substr(struk::jsonb->>'token', 1, 4) || '-' || substr(struk::jsonb->>'token', 5, 4) || '-' || substr(struk::jsonb->>'token', 9, 4) || '-' || substr(struk::jsonb->>'token', 13, 4) || '-' || substr(struk::jsonb->>'token', 17, 4) as token "
        . "from log_detail_trx where 1=1 $filter_def_noid " //detail::jsonb->>'product' = 'PLN' and detail::jsonb->>'product_detail' = 'PREPAID'
        . "and (struk::jsonb->>'nomor_meter' = '$idpel' or struk::jsonb->>'idpel' = '$idpel');";
$arr = $db->multipleRow($sql);

if (isset($arr[0]->id)) {
    $reply = json_encode($arr);
} else {
    $reply = '[]';
}
