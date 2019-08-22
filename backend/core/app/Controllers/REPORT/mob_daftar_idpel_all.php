<?php

$sql_cek = "select product,product_detail,idpel,nama_pelanggan from tbl_daftar_idpel where "
        . "noid='$noid' order by product, product_detail, idpel;";
$arr_cek = $db->multipleRow($sql_cek);

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr_cek;

$this->outputjson($response);
