
<?php

$id_add = strtoupper(trim($jreq->detail->id));
$arr = $db->singleRow("select * from log_channel_trx where id = $id_add");

if (isset($arr->id)) {
    if($arr->status == 0){
        $status = 'INQUIRY';
    }else{
        $status = 'PAYMENT';
    }
    $response = array(
        'response_code' => '0000',
        'response_message' => 'CEK DATA LOG CHANNEL TRANSAKSI BERHASIL',
        'id' => $arr->id,
        'waktu' => $arr->waktu,
        'noid' => $arr->noid,
        'product' => $arr->product,
        'product_detail' => $arr->product_detail,
        'idpel' => $arr->idpel,
        'idpel_name' => $arr->idpel_name,
        'trace_id' => $arr->trace_id,
        'tagihan' => $arr->tagihan,
        'admin_bank' => $arr->admin_bank,
        'total_tagihan' => $arr->total_tagihan,
        'response_code' => $arr->response_code,
        'response_message' => $arr->response_message,
        'status' => $status
    );
} else {
    $error->dataTidakAda($saldo_member);
}

$reply = json_encode($response);
