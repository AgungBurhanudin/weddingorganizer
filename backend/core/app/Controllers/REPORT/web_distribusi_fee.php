<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$bulan = strtoupper($jreq->detail->bulan);
$tahun = strtoupper($jreq->detail->tahun);

$selfee = "sum(cast(jfee->>'fm1' as integer)) as fee_m1, "
        . "sum(cast(jfee->>'fm2' as integer)) as fee_m2, "
        . "sum(cast(jfee->>'fm3' as integer)) as fee_m3,";
$filter_def_noid = '';

$sql = "select noid, "
        . "sum(lembar) as jumlah,"
        . "sum(profit) as profit,"
        . "$selfee "
        . "sum(cast(detail->>'admin_bank' as integer)) as admin_bank "
        . "from log_data_trx where response_code='0000' "
        . "$filter_def_noid and detail::jsonb->>'product_detail' != 'SALDO' "
        . "and to_char(waktu,'YYYYMM')='$tahun$bulan' group by noid "
        . "order by noid asc";

$arr = $db->multipleRow($sql);
$reply = '';
$profit = 0;
$noid_m1 = '';
$noid_m1_new = '';
$fee_noid_m1 = 0;
$jumlah_noid_m1 = 0;
$noid_m2 = '';
$noid_m2_new = '';
$fee_noid_m2 = 0;
$jumlah_noid_m2 = 0;
$total_fee_m3 = 0;
$i = 0;
$jumlah_arr = count($arr)-1;
foreach ($arr as $each) {
    if($i != 0){
        $noid_m2_new = substr($each->noid, 0,7).'000000000';
        $noid_m1_new = substr($each->noid, 0,3).'0000000000000';
    }
    
    if($noid_m1 == $noid_m1_new){
        $noid_m1 = substr($each->noid, 0,3).'0000000000000';
        $fee_noid_m1 += $each->fee_m1;
        $jumlah_noid_m1 += $each->jumlah;
        $isi_m1 = '';
        if($jumlah_arr == $i){
            $isi_m1 = '--------------------# '.$noid_m1.' FEE M1 = '.$fee_noid_m1 . ' ('.$jumlah_noid_m1. ') 

'; 
        }
    }else{
        $isi_m1 = '--------------------# '.$noid_m1.' FEE M1 = '.$fee_noid_m1 . ' ('.$jumlah_noid_m1. ') 

';  
        $jumlah_noid_m1 = 0;
        $fee_noid_m1 = 0;
        $noid_m1 = substr($each->noid, 0,3).'0000000000000';
        $fee_noid_m1 += $each->fee_m2;
        $jumlah_noid_m1 += $each->jumlah;
    }

    if($noid_m2 == $noid_m2_new){
        echo $isi_m1;
        echo '--# '.$each->noid.' FEE M3 = '.$fungsi->rupiah($each->fee_m3) . ' ('.$each->jumlah. ') 
'; 
        $total_fee_m3 += $each->fee_m3;
        $noid_m2 = substr($each->noid, 0,7).'000000000';
        $fee_noid_m2 += $each->fee_m2;
        $jumlah_noid_m2 += $each->jumlah;
        if($jumlah_arr == $i){
            $total_m3_m2 = $total_fee_m3+$fee_noid_m2;
            echo '----------# '.$noid_m2.' FEE M3 = '.$total_fee_m3.' FEE M2 = '.$fee_noid_m2 . ' ('.$jumlah_noid_m2. ') TOTAL = '.($total_m3_m2).' 
'; 
            $total_fee_m3 = 0;
            echo $isi_m1;
        }
    }else{
        $total_m3_m2 = $total_fee_m3+$fee_noid_m2;
        echo '----------# '.$noid_m2.' FEE M3 = '.$total_fee_m3.' FEE M2 = '.$fee_noid_m2 . ' ('.$jumlah_noid_m2. ') TOTAL = '.($total_m3_m2).'
';  
        echo $isi_m1;
        $total_fee_m3 = 0;
        echo '--# '.$each->noid.' FEE M3 = '.$fungsi->rupiah($each->fee_m3) . ' ('.$each->jumlah. ') 
'; 
        $total_fee_m3 += $each->fee_m3;
        $jumlah_noid_m2 = 0;
        $fee_noid_m2 = 0;
        $noid_m2 = substr($each->noid, 0,7).'000000000';
        $fee_noid_m2 += $each->fee_m2;
        $jumlah_noid_m2 += $each->jumlah;
        if($jumlah_arr == $i){
            $total_m3_m2 = $total_fee_m3+$fee_noid_m2;
            echo '----------# '.$noid_m2.' FEE M3 = '.$total_fee_m3.' FEE M2 = '.$fee_noid_m2 . ' ('.$jumlah_noid_m2. ') TOTAL = '.($total_m3_m2).'
';  
            $total_fee_m3 = 0;
            $isi_m1 = '--------------------# '.$noid_m1.' FEE M1 = '.$fee_noid_m1 . ' ('.$jumlah_noid_m1. ') 

'; 
            echo $isi_m1;
        }
    }
    
    $i++;
    
    
//    if($noid_m1 == substr($each->noid, 0,3).'0000000000000'){
//        $fee_noid_m1 += $each->fee_m1;
//        $jumlah_noid_m1 += $each->jumlah;
//    }else{
//        $reply .= '----------##---------- '.$noid_m1.' FEE M1 = '.$fee_noid_m1 . ' ('.$jumlah_noid_m1. ' 
//'; 
//        $fee_noid_m1 = 0;
//        $noid_m1 = substr($each->noid, 0,3).'0000000000000';
//        $fee_noid_m1 += $each->fee_m1;
//    }
//    
//    $profit += $each->profit;
    
}
