<?php

$offset = $jreq->start != '' ? $jreq->start : 1;
$rows = $jreq->length != '' ? $jreq->length : 10;

$sort = 'noid';
$order = 'asc';
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

$sql = "select tipe,noid,nama,nohp_email,alamat,provinsi,kota_kabupaten,saldo,"
        . "to_char(last_date,'YYYY-MM-DD HH24:MI:SS') as last_transaction,today_trx, month_trx "
        . "from tbl_member_account where jenis = 1 $filter_def_noid order by $sort $order limit $rows offset $offset;";
$sql_count = "select count(id) as jml from tbl_member_account where jenis = 1 $filter_def_noid;";

$arr_count = $db->singleRow($sql_count);
$result['draw'] = $jreq->draw;
$result['recordsTotal'] = $arr_count->jml;
$result['recordsFiltered'] = $arr_count->jml;
$result['data'] = $db->multipleRow($sql);
$this->outputJSON($result);
