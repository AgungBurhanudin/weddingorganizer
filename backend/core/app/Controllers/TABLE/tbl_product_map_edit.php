<?php

$product_add = strtoupper($jreq->detail->product);
$product_detail_add = strtoupper($jreq->detail->product_detail);
$biller_add = strtoupper($jreq->detail->biller);
$kode_h2h_add = strtoupper($jreq->detail->kode_h2h);
$status_add = strtoupper($jreq->detail->status);
$provider_add = strtoupper($jreq->detail->provider);
$hpp_add = strtoupper($jreq->detail->hpp);
$admin_bank_add = strtoupper($jreq->detail->admin_bank);
$margin_add = strtoupper($jreq->detail->margin);
$id_add = strtoupper(trim($jreq->detail->id));

$arr = $db->cekId('tbl_product_map','id',$id_add);

if (isset($arr->id)) {
    $product = $arr->product;
    $product_detail = $arr->product_detail;
    $sql = "BEGIN TRANSACTION;"
            . "UPDATE tbl_product_map SET product='$product_add', product_detail='$product_detail_add',biller ='$biller_add',"
			. "kode_h2h='$kode_h2h_add',provider ='$provider_add',hpp='$hpp_add',admin_bank='$admin_bank_add',"
			. "margin ='$margin_add' WHERE id = $id_add;"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "UPDATE Transaksi Kode Trx:$id_add BERHASIL",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

