<?php

$id_add = strtoupper(trim($jreq->detail->id));

$arr_cek = $db->singleRow("SELECT id,product,product_detail FROM tbl_product_map where id = $id_add");

if (isset($arr_cek->id)) {
	$id = $arr_cek->id;
	$product = $arr_cek->product;
	$product_detail = $arr_cek->product_detail;
	$sql = "BEGIN TRANSACTION;"
			. "delete from tbl_product_map where id = $id_add;"
			. "COMMIT";
	$db->singleRow($sql);
	$response = array(
		'response_code' => '0000',
		'response_message' => "Sukses HAPUS $product $product_detail dengan Kode Trx: $id ",
		'saldo' => $saldo_member
	);
} else {
	$error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

