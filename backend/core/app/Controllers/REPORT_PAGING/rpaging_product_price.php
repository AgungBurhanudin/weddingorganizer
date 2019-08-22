<?php

$noid_add = isset($jreq->detail->noid) ? $jreq->detail->noid : $noid;
$arr_member_add = $db->cekNoidMember($noid_add);

if ($arr_member_add->tipe == 'M3') {
    $noid_m1 = substr($noid_add, 0, 3) . '0000000000000';
    $noid_m2 = substr($noid_add, 0, 7) . '000000000';
    $sql_member = "select noid,fee from tbl_member_account where noid='$noid_add' or "
            . "noid='$noid_m2' or noid='$noid_m1' order by noid asc;";
    $result_member = $db->multipleRow($sql_member);
    $arr_fee_m1 = json_decode($result_member[0]->fee);
    $arr_fee_m2 = json_decode($result_member[1]->fee);
    $arr_fee_m3 = json_decode($result_member[2]->fee);

//Margin Pusat dan data produk
    $sql = "select * from tbl_product_map where product = 'PULSA' order by provider,hpp asc;";
    $result = $db->multipleRow($sql);
    $data = array();
    $i = 0;
    if (isset($result[0]->id)) {
        foreach ($result as $fetch) {
            $data[$i]['noid'] = $noid_add;
            $data[$i]['produk'] = $fetch->product . '-' . $fetch->product_detail;
            $data[$i]['status'] = $fetch->status;
            $fee_m1 = (isset($arr_fee_m1->{$fetch->product . $fetch->product_detail})) ? $arr_fee_m1->{$fetch->product . $fetch->product_detail} : 100;
            $fee_m2 = (isset($arr_fee_m2->{$fetch->product . $fetch->product_detail})) ? $arr_fee_m2->{$fetch->product . $fetch->product_detail} : 100;
            $fee_m3 = (isset($arr_fee_m3->{$fetch->product . $fetch->product_detail})) ? $arr_fee_m3->{$fetch->product . $fetch->product_detail} : 100;
            
            if ($noid == $noid_add) { // m3
                $data[$i]['harga_m3'] = $fee_m1 + $fee_m2 + $fee_m3 + $fetch->hpp;
            } elseif ($tipe_member == 'M2') {
                $data[$i]['harga_m2'] = $fee_m1 + $fee_m2 + $fetch->hpp;
                $data[$i]['harga_m3'] = $fee_m1 + $fee_m2 + $fee_m3 + $fetch->hpp;
                $data[$i]['fee_m3'] = $fee_m3;
            } else {
                $data[$i]['harga_m1'] = $fee_m1 + $fetch->hpp;
                if($jenis_member == 2){
                    $data[$i]['harga_hpp'] = $fetch->hpp;
                    $data[$i]['fee_m1'] = $fee_m1;
                    $data[$i]['biller'] = $fetch->biller;
                }
                $data[$i]['harga_m2'] = $fee_m1 + $fee_m2 + $fetch->hpp;
                $data[$i]['fee_m2'] = $fee_m2;
                $data[$i]['harga_m3'] = $fee_m1 + $fee_m2 + $fee_m3 + $fetch->hpp;
                $data[$i]['fee_m3'] = $fee_m3;
            }
            $i++;
        }
        $isi = json_encode($data);
    } else {
        $isi = '[]';
    }
}elseif($arr_member_add->tipe == 'M2'){
    $noid_m1 = substr($noid_add, 0, 3) . '0000000000000';
    $sql_member = "select noid,fee from tbl_member_account where noid='$noid_add' or "
            . "noid='$noid_m1' order by noid asc;";
    $result_member = $db->multipleRow($sql_member);
    $arr_fee_m1 = json_decode($result_member[0]->fee);
    $arr_fee_m2 = json_decode($result_member[1]->fee);

//Margin Pusat dan data produk
    $sql = "select * from tbl_product_map where product = 'PULSA' order by provider,hpp asc;";
    $result = $db->multipleRow($sql);
    $data = array();
    $i = 0;
    if (isset($result[0]->id)) {
        foreach ($result as $fetch) {
            $data[$i]['noid'] = $noid_add;
            $data[$i]['produk'] = $fetch->product . '-' . $fetch->product_detail;
            $data[$i]['status'] = $fetch->status;
            $fee_m1 = (isset($arr_fee_m1->{$fetch->product . $fetch->product_detail})) ? $arr_fee_m1->{$fetch->product . $fetch->product_detail} : 100;
            $fee_m2 = (isset($arr_fee_m2->{$fetch->product . $fetch->product_detail})) ? $arr_fee_m2->{$fetch->product . $fetch->product_detail} : 100;
            
            
            if ($noid == $noid_add) { // m2
                $data[$i]['harga_m2'] = $fee_m1 + $fee_m2 + $fetch->hpp;
            } else {
                $data[$i]['harga_m1'] = $fee_m1 + $fetch->hpp;
                if($jenis_member == 2){
                    $data[$i]['harga_hpp'] = $fetch->hpp;
                    $data[$i]['fee_m1'] = $fee_m1;
                    $data[$i]['biller'] = $fetch->biller;
                }
                $data[$i]['harga_m2'] = $fee_m1 + $fee_m2 + $fetch->hpp;
                $data[$i]['fee_m2'] = $fee_m2;
            }
            $i++;
        }
        $isi = json_encode($data);
    } else {
        $isi = '[]';
    }
}elseif($arr_member_add->tipe == 'M1'){
    $sql_member = "select noid,fee from tbl_member_account where noid='$noid_add' order by noid asc;";
    $result_member = $db->multipleRow($sql_member);
    $arr_fee_m1 = json_decode($result_member[0]->fee);

//Margin Pusat dan data produk
    $sql = "select * from tbl_product_map where product = 'PULSA' order by provider,hpp asc;";
    $result = $db->multipleRow($sql);
    $data = array();
    $i = 0;
    if (isset($result[0]->id)) {
        foreach ($result as $fetch) {
            $data[$i]['noid'] = $noid_add;
            $data[$i]['produk'] = $fetch->product . '-' . $fetch->product_detail;
            $data[$i]['status'] = $fetch->status;
            $fee_m1 = (isset($arr_fee_m1->{$fetch->product . $fetch->product_detail})) ? $arr_fee_m1->{$fetch->product . $fetch->product_detail} : 100;
            
            if ($noid == $noid_add) { // m2
                $data[$i]['harga_m1'] = $fee_m1 + $fetch->hpp;
            } else {
                $data[$i]['harga_hpp'] = $fetch->hpp;
                $data[$i]['harga_m1'] = $fee_m1 + $fetch->hpp;
                $data[$i]['fee_m1'] = $fee_m1;
                $data[$i]['biller'] = $fetch->biller;
            }
            $i++;
        }
        $isi = json_encode($data);
    } else {
        $isi = '[]';
    }
}else{
    $i = 0;
    $isi = '[]';
}
$result = '{"draw":"' . $jreq->draw . '","recordsTotal":"' . $i . '","recordsFiltered":"' . $i . '","data":' . $isi . '}';
echo $result;
