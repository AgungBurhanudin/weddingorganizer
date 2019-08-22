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

//$filter_status = !isset($jreq->status) ? '' : "and status = $jreq->status";
$filter_bank='';
if(isset($jreq->bank)){
$filter_bank = strlen($jreq->bank) < 3 ? '' : "and bank = '$jreq->bank'";
}
$filter_noid = $search == '' ? '' : "and noid = '$search'";


$sql = "select id,waktu::timestamp(0) as waktu,interface,noid,alias,bank,norek_tujuan,nominal,status,keterangan,reff,waktu_proses,noid_executor,bukti_transfer "
        . "from log_konfirmasi_topup where 1=1 and (status =1 or date(waktu) = date(now())) $filter_bank $filter_noid "
        . "$filter_def_noid order by $sort $order limit $rows offset $offset;";

$wLog->writeLog($interface, 'RPAGING_'.$tipe_request, $sql);

$sql_count = "select count(id) as jml from log_konfirmasi_topup where 1=1 $filter_bank $filter_noid $filter_def_noid;";

$arr_count = $db->singleRow($sql_count);
$result['draw'] = $jreq->draw;
$result['recordsTotal'] = $arr_count->jml;
$result['recordsFiltered'] = $arr_count->jml;
$result['data'] = $db->multipleRow($sql);
$this->outputJSON($result);
