<?php

$offset = $jreq->start != '' ? $jreq->start : 1;
$rows = $jreq->length != '' ? $jreq->length : 10;

$sort = 'id';
$order = $jreq->order[0]->dir != '' ? $jreq->order[0]->dir : 'desc';
$search = $jreq->search->value;
$filter = isset($jreq->filter_tipe) ? $jreq->filter_tipe : "" ;

if ($tipe_member == 'M1') {
    $def_noid = substr($noid, 0,3);
    $filter_def_noid = "and substring(mc.noid from 1 for 3) = '$def_noid'";
} elseif ($tipe_member == 'M2') {
    $def_noid = substr($noid, 0,7);
    $filter_def_noid = "and substring(mc.noid from 1 for 7) = '$def_noid'";
} elseif ($tipe_member == 'M3') {
    $filter_def_noid = "and mc.noid = '$noid'";
} else {
    $filter_def_noid = '';
}

$filter_search = $search == '' ? '' : "and (mc.noid like '%$search%' or upper(alias) like upper('%$search%') or upper(nama) like upper('%$search%'))";

if($filter != ""){
    $filter_search .= "AND ma.tipe = '$filter'";
}

$sql = "select row_number() over (ORDER BY id) as no,id,interface,mc.noid,ma.tipe,alias,reg_date::timestamp(0),last_used::timestamp(0),"
        . "CASE WHEN status=0 THEN 'BLOK' "
        . "WHEN status=1 THEN 'AKTIF' "
        . "ELSE 'OTP' END as status,salah_pin,nama,email from tbl_member_channel mc "
        . "left join (select tipe,noid from tbl_member_account) as ma on ma.noid = mc.noid "
        . "where 1=1 $filter_search $filter_def_noid order by $sort $order limit $rows offset $offset;";
$sql_count = "select count(id) as jml from tbl_member_channel mc where 1=1 $filter_search $filter_def_noid;";
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
