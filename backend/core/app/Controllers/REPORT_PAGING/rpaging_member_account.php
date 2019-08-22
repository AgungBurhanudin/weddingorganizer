<?php

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

$filter_search = $search == '' ? '' : "and (noid like '%$search%' or upper(nama) like upper('%$search%') or upper(nohp_email) like upper('%$search%'))";
$filter_search_tipe = $jreq->filter_tipe == '' ? '' : "and (tipe = '$jreq->filter_tipe')";

$sql = "select row_number() over (ORDER BY id) as no,id,noid,nama,saldo,limit_saldo,nohp_email,tipe,alamat,saldo_sekolah,"
        . "reg_date::timestamp(0) as reg_date, "
        . "CASE WHEN tipe='M1' THEN hak_saldo "
        . "WHEN tipe='M2' THEN hak_saldo "
        . "WHEN tipe='M3' THEN fee_dist "
        . "ELSE 5 END as fee_dist "
        . "from tbl_member_account "
        . "where 1=1 $filter_search $filter_search_tipe $filter_def_noid order by $sort $order limit $rows offset $offset;";
$sql_count = "select count(id) as jml from tbl_member_account where 1=1 $filter_search $filter_search_tipe $filter_def_noid;";
$data = $db->multipleRow($sql);
$i = 1;
foreach ($data as $key => $value) {
    $data[$key]->no = $i++;
}

$arr_count = $db->singleRow($sql_count);
$result['draw'] = $jreq->draw;
$result['recordsTotal'] = $arr_count->jml;
$result['recordsFiltered'] = $arr_count->jml;
$result['data'] = $data;
$this->outputJSON($result);
