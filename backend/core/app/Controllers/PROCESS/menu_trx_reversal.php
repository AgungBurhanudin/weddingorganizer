<?php
/*
 * {
"tipe_request": "reversal",
  "detail": {
    "noid_destination" : "noid",
    "idtrx" : "id_trx"
  }
"appid": "LLJ3C5VGKEZP9KI",
"token": "9TMSN72QJHH4"
}
 */

$noid_add = $jreq->detail->noid_destination;
$idtrx_add = strtoupper($jreq->detail->idtrx);

if($jenis_member != 2){
    $error->menuTidakBerhak($saldo_member);
}

$sql_cek_trx = "select amount,detail from log_data_trx where id = $idtrx_add and noid = '$noid_add' and (stat = 1 or stat = 3) and detail::jsonb->>'product_detail' != 'SALDO';";
$arr_cek_trx = $db->singleRow($sql_cek_trx);
if(isset($arr_cek_trx->amount)){
    $amount_minus = $arr_cek_trx->amount;
    $json_data = json_decode($arr_cek_trx->detail);
    $json_data->response_message = 'REVERSAL '.$json_data->product.' '.$json_data->product_detail.' '.$json_data->idpel.' '.$json_data->idpel_name;
    $json_data->product = 'REVERSAL';
    $json_data->product_detail = 'SALDO';
    $lembar = $json_data->lembar;
    $djson_reply = json_encode($json_data);
    $amount = $json_data->amount;
    
    $sql_potong_saldo = "update tbl_member_account set saldo = saldo + $amount,last_trx='$djson_reply',last_amount=$amount,last_reff='$ref',last_fee='{}',"
                    . "last_date = now(),last_lembar=$lembar where noid = '$noid_add' returning saldo;";
    
    $arr_potong_saldo = $db->singleRow($sql_potong_saldo);
    $saldo_member = $arr_potong_saldo->saldo;
    
    $sql_summary_rev = "update log_data_trx set stat=2 where id = $idtrx_add;";
    $db->singleRow($sql_summary_rev);
    
    $response = array(
        'response_code' => '0000',
        'response_message' => "REVERSAL TRANSAKSI IDTRX: $idtrx_add NOID:".$noid_add." PRODUK:".$json_data->product_detail." ".$json_data->idpel." ".$json_data->amount." BERHASIL"
    );
    
    
    $msg_out = 'REVERSAL TRANSAKSI IDTRX: '.$idtrx_add.' NOID:'.$noid_add.' PRODUK:'.$json_data->product_detail.' '.$json_data->idpel.' a.n '.$json_data->idpel.' Rp. '.$fungsi->rupiah($amount).' . Saldo Rp. '.$fungsi->rupiah($saldo_member);
    $db->kirimMessage($noid_add, $msg_out);
}else{
    $response = array(
        'response_code' => '0402',
        'response_message' => "REVERSAL TRANSAKSI GAGAL, data tidak ditemukan."
    );
}

$reply = json_encode($response);