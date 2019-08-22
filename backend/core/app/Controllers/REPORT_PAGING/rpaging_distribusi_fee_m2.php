<?php

$offset = $jreq->start != '' ? $jreq->start : 1;
$rows = $jreq->length != '' ? $jreq->length : 10;

$sort = 'id';
$order = $jreq->order[0]->dir != '' ? $jreq->order[0]->dir : 'desc';
$search = $jreq->search->value;

$def_noid = substr($jreq->detail->noid, 0,3);
$filter_def_noid = "and substring(noid from 1 for 3) = '$def_noid'";

$filter_search = $search == '' ? '' : "and (noid like '%$search%' or upper(nama) like upper('%$search%') or upper(nohp_email) like upper('%$search%'))";

$sql = "select row_number() over (ORDER BY id) as no,id,noid,nama,'process' as fee_m1, 'process' as fee_total_m1, 'process' as fee_m2, 'process' as fee_total_m2 "
        . "from tbl_member_account "
        . "where tipe = 'M2' $filter_search $filter_def_noid order by $sort $order limit $rows offset $offset;";
$sql_count = "select count(id) as jml from tbl_member_account where tipe = 'M2' $filter_search $filter_def_noid;";

$arr_count = $db->singleRow($sql_count);
$result['draw'] = $jreq->draw;
$result['recordsTotal'] = $arr_count->jml;
$result['recordsFiltered'] = $arr_count->jml;
$result['data'] = $db->multipleRow($sql);
$this->outputJSON($result);
