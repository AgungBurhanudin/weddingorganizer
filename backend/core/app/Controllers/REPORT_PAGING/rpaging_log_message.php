<?php

$offset = $jreq->start != '' ? $jreq->start : 1;
$rows = $jreq->length != '' ? $jreq->length : 10;

$sort = 'id';
$order = $jreq->order[0]->dir != '' ? $jreq->order[0]->dir : 'desc';
$search = $jreq->search->value;

if ($tipe_member == 'M1') {
    $def_noid = substr($noid, 0, 3);
    $filter_def_noid = "and (substring(noid from 1 for 3) = '$def_noid' or pusat = 1)";
} elseif ($tipe_member == 'M2') {
    $def_m1 = substr($noid, 0, 3).'0000000000000';
    $def_noid = substr($noid, 0, 7);
    $filter_def_noid = "and (substring(noid from 1 for 7) = '$def_noid' or m1 = '$def_m1' or pusat = 1)";
} elseif ($tipe_member == 'M3') {
    $def_m1 = substr($noid, 0, 3).'0000000000000';
    $def_m2 = substr($noid, 0, 7).'000000000';
    $filter_def_noid = "and (noid = '$noid' or m1 = '$def_m1' or m2 = '$def_m2' or pusat = 1)";
} else {
    $filter_def_noid = '';
}

$arr_mbch = $db->cekAliasChannel($username);
$last_seen = $arr_mbch->last_message;

$filter_search = $search == '' ? '' : "and (noid like '%$search%' or upper(nohp_email) like upper('%$search%'))";

$sql = "select id,waktu::timestamp(0) as waktu,noid,nohp_email,interface,reff,stat,"
        . "regexp_replace(msg,'=......','=XXXXXX','g') as message,"
        . "case when waktu < '$last_seen' then 1 else 0 end as dibaca from log_message "
        . "where 1=1 "
        . "$filter_def_noid order by $sort $order limit $rows offset $offset;";

$sql_count = "select count(id) as jml from log_message where 1=1 $filter_def_noid;";

//update last message inbox
$sql_update_last_msg = "update tbl_member_channel set last_message = now() "
        . "where noid = '$noid' and alias = '$username';";
$db->singleRow($sql_update_last_msg);

$arr_count = $db->singleRow($sql_count);
$result['draw'] = $jreq->draw;
$result['recordsTotal'] = $arr_count->jml;
$result['recordsFiltered'] = $arr_count->jml;
$result['data'] = $db->multipleRow($sql);
$this->outputJSON($result);
