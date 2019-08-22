<?php

$product = strtoupper($jreq->detail->product);
$product_detail = strtoupper($jreq->detail->product_detail);

$sql_cek = "select * from tbl_daftar_idpel where noid='$noid' and product='$product' and product_detail='$product_detail';";
$arr = $db->singleRow($sql_cek);

if (isset($arr[0]->id)) {
    $reply = json_encode($arr);
} else {
    $reply = '[]';
}
