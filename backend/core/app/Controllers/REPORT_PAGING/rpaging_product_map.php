<?php

$offset = $jreq->start != '' ? $jreq->start : 1;
$rows = $jreq->length != '' ? $jreq->length : 10;

$sort = 'product,product_detail';
$order = $jreq->order[0]->dir != '' ? $jreq->order[0]->dir : 'asc';
$search = $jreq->search->value;


$filter_search = $search == '' ? '' : "and (upper(product) like upper('%$search%') or upper(product_detail) like upper('%$search%'))";

$sql = "select * from tbl_product_map "
        . "where 1=1 $filter_search order by $sort $order limit $rows offset $offset;";
$sql_count = "select count(id) as jml from tbl_product_map where 1=1 $filter_search;";

$arr_count = $db->singleRow($sql_count);
$result['draw'] = $jreq->draw;
$result['recordsTotal'] = $arr_count->jml;
$result['recordsFiltered'] = $arr_count->jml;
$result['data'] = $db->multipleRow($sql);
$this->outputJSON($result);
