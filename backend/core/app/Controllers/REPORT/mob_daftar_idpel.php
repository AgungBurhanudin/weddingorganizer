<?php

$action = strtoupper($jreq->detail->action);

if ($action == 'LIST') {
    $product = strtoupper($jreq->detail->product);
    $filter_pd = '';
    if (isset($jreq->detail->product_detail)) {
        $product_detail = strtoupper($jreq->detail->product_detail);
        $filter_pd = "and product_detail='$product_detail'";
    }
    $noid = $jreq->noid;
    $sql_cek = "select idpel,nama_pelanggan from tbl_daftar_idpel where noid='$noid' and product='$product' $filter_pd;";
    $arr_cek = $db->multipleRow($sql_cek);

    $response['response_code'] = '0000';
    $response['response_message'] = 'OK';
    $response['data'] = $arr_cek;

} elseif ($action == 'ADD') {
    $product = strtoupper($jreq->detail->product);
    $product_detail = strtoupper($jreq->detail->product_detail);
    $idpel_add = strtoupper($jreq->detail->idpel);
    $nama_add = strtoupper($jreq->detail->nama);
    $noid = $jreq->noid;
    $sql_cek = "select * from tbl_daftar_idpel where idpel = '$idpel_add' and noid='$noid' and product='$product' and product_detail='$product_detail';";
    $arr = $db->singleRow($sql_cek);

    if (!isset($arr->id)) {
        //belum ada idpel tersebut
        $sql_add = "BEGIN TRANSACTION;"
                . "insert into tbl_daftar_idpel(noid,idpel,nama_pelanggan,product,product_detail) values ('$noid','$idpel_add','$nama_add','$product','$product_detail');"
                . "COMMIT;";
        $db->singleRow($sql_add);
        $response = array(
            'response_code' => '0000',
            'response_message' => "Berhasil Input data"
        );
    } else {
        //sudah ada idpel tersebut
        $response = array(
            'response_code' => '0099',
            'response_message' => "Gagal Input data, IDPEL sudah tersedia."
        );
    }
    
}
$reply = json_encode($response);