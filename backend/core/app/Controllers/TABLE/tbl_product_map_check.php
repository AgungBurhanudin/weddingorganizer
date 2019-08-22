<?php

$id_add = strtoupper(trim($jreq->detail->id));
$arr = $db->singleRow("SELECT id,product,product_detail,biller,kode_h2h,provider,hpp,admin_bank,margin from tbl_product_map where id = $id_add");

if (isset($arr->id)) {
    $response = array(
        'response_code' => '0000',
        'response_message' => 'CEK DATA BERHASIL',
        'product' => $arr->product,
        'product_detail' => $arr->product_detail,
        'biller' => $arr->biller,
        'kode_h2h' => $arr->kode_h2h,
		'provider'=> $arr->provider,
		'hpp' => $arr->hpp,
		'admin_bank' => $arr->admin_bank,
		'margin' => $arr->margin,
		'id' => $arr->id
    );
} else {
    $error->dataTidakAda($saldo_member);
}

$reply = json_encode($response);
