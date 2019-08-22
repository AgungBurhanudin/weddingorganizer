<?php

$offset = $jreq->start != '' ? $jreq->start : 1;
$rows = $jreq->length != '' ? $jreq->length : 10;

$sort = 'idpel';
$order = $jreq->order[0]->dir != '' ? $jreq->order[0]->dir : 'asc';
$search = $jreq->search->value;


$id_group = isset($jreq->id_group) ? $jreq->id_group : 0;

$filter_search = $search == '' ? '' : "and (idpel = '%$search%' or upper(idpel_name) like upper('%$search%'))";

$sql = "select id,idpel,idpel_name,tagihan,admin_bank,total_tagihan,bulan,keterangan from tbl_group_kolektif_detail "
        . "where id_group = $id_group $filter_search order by $sort $order limit $rows offset $offset;";
$sql_count = "select count(id) as jml from tbl_group_kolektif_detail where id_group = $id_group $filter_search;";

$arr_count = $db->singleRow($sql_count);
$result['draw'] = $jreq->draw;
$result['recordsTotal'] = $arr_count->jml;
$result['recordsFiltered'] = $arr_count->jml;
$result['data'] = $db->multipleRow($sql);
$this->outputJSON($result);
