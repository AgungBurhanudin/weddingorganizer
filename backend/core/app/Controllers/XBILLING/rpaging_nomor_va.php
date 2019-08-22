<?php

$dbbi = new Models\DbBilling();

$offset = $jreq->start != '' ? $jreq->start : 1;
$rows = $jreq->length != '' ? $jreq->length : 10;

$sort = 'id';
$order = $jreq->order[0]->dir != '' ? $jreq->order[0]->dir : 'desc';
$search = $jreq->search->value;

if ($tipe_member == 'M1') {
    $def_noid = substr($noid, 0,3);
    $filter_def_noid = "and substring(noid from 1 for 3) = '$def_noid'";
} elseif ($tipe_member == 'M2') {
    $def_noid = substr($noid, 0,7);
    $filter_def_noid = "and substring(noid from 1 for 7) = '$def_noid'";
} elseif ($tipe_member == 'M3') {
    $filter_def_noid = "and noid = '$noid'";
} else {
    $filter_def_noid = '';
}

$filter_search = $search == '' ? '' : "and (noid like '%$search%' or upper(keterangan) like upper('%$search%'))";

$sql = "select * from tbl_nomor_va "
        . "where 1=1 $filter_search $filter_def_noid order by $sort $order limit $rows offset $offset;";
$sql_count = "select count(id) as jml from tbl_nomor_va where 1=1 $filter_search $filter_def_noid;";

$arr_count = $dbbi->singleRow($sql_count);
$result['draw'] = $jreq->draw;
$result['recordsTotal'] = $arr_count->jml;
$result['recordsFiltered'] = $arr_count->jml;
$result['data'] = $dbbi->multipleRow($sql);
$this->outputJSON($result);
