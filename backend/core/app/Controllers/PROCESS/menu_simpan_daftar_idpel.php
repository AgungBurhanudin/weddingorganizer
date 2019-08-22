<?php

$tujuan_add = strtoupper($jreq->detail->tujuan);
$amount_add = $jreq->detail->nominal;
$arr_member = $db->cekNoidMember($noid);

if($amount_add > 10000){

    $tiket = $fungsi->randomNumberTiket(3);
    $amount_tiket = $amount_add + $tiket;
    $sql_konf = "insert into log_konfirmasi_deposit (waktu,interface,alias,noid,bank,nominal,status,keterangan,reff) "
        . "values (now(),'$interface','$username','$noid','$tujuan_add','$amount_tiket',0,'$tiket','$ref');";
    
    $db->singleRow($sql_konf);
    
    $norek = $db->cekKonfig('NOREK_'+$tujuan_add);
    $response = array(
        'response_code' => '0000',
        'response_message' => 'Silahkan melakukan transfer sebesar Rp. '.$fungsi->rupiah($amount_tiket).' ke '.$tujuan_add.' Norek : '.$norek.'. Saldo saat ini Rp. '. $fungsi->rupiah($saldo_member),
        'saldo' => $saldo_member
    ); 
}else{
    $response = array(
        'response_code' => '0095',
        'response_message' => 'Nominal harus diatas Rp. 10.000,-',
        'saldo' => $saldo_member
    );
}


$reply = json_encode($response);
