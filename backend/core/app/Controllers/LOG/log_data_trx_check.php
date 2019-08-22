<?php

$id_add = strtoupper(trim($jreq->detail->id));
$arr = $db->singleRow("select id,waktu,noid,detail::jsonb->>'product' as product,"
        . "detail::jsonb->>'product_detail' as product_detail,"
        . "detail::jsonb->>'idpel' as idpel,"
        . "detail::jsonb->>'idpel_name' as idpel_name, "
        . "amount,saldo,reff,stat, "
        . "detail::jsonb->>'tagihan' as tagihan,"
        . "detail::jsonb->>'admin_bank' as admin_bank,"
        . "detail::jsonb->>'total_tagihan' as total_tagihan,"
        . "detail::jsonb->>'response_code' as response_code "
        . "from log_data_trx where id = $id_add");

if (isset($arr->id)) {
    switch ($arr->stat) {
        case 0:
            $status = 'PROSES';
            break;
        case 1:
            $status = 'SUKSES';
            break;
        case 2:
            $status = 'GAGAL';
            break;
        case 3:
            $status = 'PENDING';
            break;
        case 4:
            $status = 'REVERSAL_MANUAL';
            break;
        case 5:
            $status = 'SUKSES_MANUAL';
            break;
    }

    $response = array(
        'response_code' => '0000',
        'response_message' => 'CEK DATA TRANSAKSI BERHASIL',
        'id' => $arr->id,
        'waktu' => $arr->waktu,
        'noid' => $arr->noid,
        'product' => $arr->product,
        'product_detail' => $arr->product_detail,
        'idpel' => $arr->idpel,
        'idpel_name' => $arr->idpel_name,
        'amount' => $arr->amount,
        'saldo' => $arr->saldo,
        'tagihan' => $arr->tagihan,
        'admin_bank' => $arr->admin_bank,
        'total_tagihan' => $arr->total_tagihan,
        'response_code' => $arr->response_code,
        'status' => $status
    );
} else {
    $error->dataTidakAda($saldo_member);
}

$reply = json_encode($response);

