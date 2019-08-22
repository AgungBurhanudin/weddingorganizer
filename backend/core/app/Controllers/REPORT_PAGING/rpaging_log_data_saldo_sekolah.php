<?php

$offset = $jreq->start != '' ? $jreq->start : 1;
$rows = $jreq->length != '' ? $jreq->length : 10;

$sort = 'id';
$order = $jreq->order[0]->dir != '' ? $jreq->order[0]->dir : 'desc';
$search = $jreq->search->value;

if ($tipe_member == 'M1') {
    $def_noid = substr($noid, 0, 3);
    $filter_def_noid = "and substring(noid from 1 for 3) = '$def_noid'";
} elseif ($tipe_member == 'M2') {
    $def_noid = substr($noid, 0, 7);
    $filter_def_noid = "and substring(noid from 1 for 7) = '$def_noid'";
} elseif ($tipe_member == 'M3') {
    $filter_def_noid = "and noid = '$noid'";
} else {
    $filter_def_noid = '';
}

$filter_product_detail = "and detail::jsonb->>'product_detail' = 'SALDO'";

$filter_search = $search == '' ? '' : "and (detail::jsonb->>'idpel' like '%$search%' or upper(detail::jsonb->>'idpel_name') like upper('%$search%'))";

$sql = "select id,to_char(waktu,'YYYY-MM-DD HH24:MI:SS') as waktu,"
        . "noid, "
        . "reff, saldo - amount as saldo_before, "
        . "amount, "
        . "saldo, "
        . "detail::jsonb->>'interface' as interface, " //WEB / MOBILE
        . "detail::jsonb->>'product' as product, " //topup
        . "detail::jsonb->>'product_detail' as product_detail, " //saldo
        . "detail::jsonb->>'idpel' as idpel, " //noid
        . "detail::jsonb->>'idpel_name' as idpel_name, " //nama
        . "detail::jsonb->>'response_code' as response_code, "
        . "detail::jsonb->>'keterangan' as keterangan, " //nohp_email
        . "detail::jsonb->>'lembar' as lembar, "
        . "detail::jsonb->>'trace_id' as trace_id "
        . "from log_data_trx where 1=1 AND is_flexible = 1 "
        . " $filter_product_detail "
        . " $filter_search "
        . "$filter_def_noid order by $sort $order limit $rows offset $offset;";

$sql_count = "select count(id) as jml from log_data_trx where 1=1 AND is_flexible = 1 "
        . " $filter_product_detail "
        . " $filter_search "
        . "$filter_def_noid;";


$arr_count = $db->singleRow($sql_count);
$result['draw'] = $jreq->draw;
$result['recordsTotal'] = $arr_count->jml;
$result['recordsFiltered'] = $arr_count->jml;
$result['data'] = $db->multipleRow($sql);
$this->outputJSON($result);
