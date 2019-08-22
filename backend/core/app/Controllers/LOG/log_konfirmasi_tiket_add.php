<?php

$tujuan_add = strtoupper($jreq->detail->tujuan);
$amount_add = $jreq->detail->nominal;
$arr_member = $db->cekNoidMember($noid);

if($amount_add % 10000 == 0){

    $sql_cek = "select count(id) as jml from log_konfirmasi_topup where nominal_asli = $amount_add "
            . "and date(waktu) = date(now()) and bank = '$tujuan_add';";
    $arr_cek = $db->singleRow($sql_cek);
    $tiket = $arr_cek->jml + 1;
    $amount_tiket = $amount_add + $tiket;
    $norek = $db->cekKonfig('NOREK_'.$tujuan_add);
    $sql_konf = "insert into log_konfirmasi_topup (waktu,interface,alias,noid,bank,norek_tujuan,nominal,status,keterangan,reff,nominal_asli) "
        . "values (now(),'$interface','$username','$noid','$tujuan_add','$norek','$amount_tiket',0,'$tiket','$ref',$amount_add);";
    
    $db->singleRow($sql_konf);
    
    $response = array(
        'response_code' => '0000',
        'response_message' => 'Silahkan melakukan transfer sebesar Rp. '.$fungsi->rupiah($amount_tiket).' ke '.$tujuan_add.' Norek : '.$norek
            .'. Saldo saat ini Rp. '. $fungsi->rupiah($saldo_member) . '. Silahkan Transfer sebelum pukul 23.00 WIB',
        'saldo' => $saldo_member
    ); 
}else{
    $response = array(
        'response_code' => '0095',
        'response_message' => 'Nominal harus kelipatan 10.000,-',
        'saldo' => $saldo_member
    );
}


$reply = json_encode($response);
