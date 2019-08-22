<?php

$offset = $jreq->start != '' ? $jreq->start : 1;
$rows = $jreq->length != '' ? $jreq->length : 10;

$sort = 'id';
$order = $jreq->order[0]->dir != '' ? $jreq->order[0]->dir : 'desc';
$search = $jreq->search->value;

$filter_search = $search == '' ? '' : "and (noid like '%$search%')";

$sql = "select id,waktu::timestamp(0) as waktu,noid,tipe_file,tipe_request,keterangan,kode_validasi,status,tipe_validator,"
        . "noid_validator,waktu_validasi::timestamp(0) as waktu_validasi from log_otorisasi "
        . "where 1=1 $filter_search order by $sort $order limit $rows offset $offset;";
$sql_count = "select count(id) as jml from log_otorisasi where 1=1 $filter_search;";

$arr_count = $db->singleRow($sql_count);
$result['draw'] = $jreq->draw;
$result['recordsTotal'] = $arr_count->jml;
$result['recordsFiltered'] = $arr_count->jml;
$result['data'] = $db->multipleRow($sql);
$this->outputJSON($result);
