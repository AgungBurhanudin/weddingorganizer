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

$sql = "BEGIN TRANSACTION;"
		. "INSERT INTO tbl_product_map ( product, product_detail, biller, kode_h2h, status, provider, hpp, admin_bank, margin) VALUES "
		. "('$product_add','$product_detail_add','$biller_add','$kode_h2h_add','$status_add','$provider_add','$hpp_add','$admin_bank_add','$margin_add');"
		. "COMMIT;";
$db->singleRow($sql);
$response = array(
	'response_code' => '0000',
	'response_message' => "TRANSAKSI $product_add $product_detail_add BERHASIL",
	'saldo' => $saldo_member
);

$reply = json_encode($response);
