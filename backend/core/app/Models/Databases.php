<?php

namespace Models;

use Resources,
    Libraries;

class Databases {

    public function __construct() {
        $this->db = new Resources\Database;
        $this->error = new Libraries\ResponseError;
    }

    public function singleRow($sql) {
        return $this->db->row($sql);
    }
    
    public function query($sql) {
        return $this->db->query($sql);
    }

    public function multipleRow($sql) {
        return $this->db->results($sql);
    }

    public function cekmutasi($id_mutasi) {
        $sql_cek = "select count(a.*) as a,count(b.*) as b from tbl_mutasi_anak a join tbl_mutasi_kenaikan_gaji b on a.id_mutasi = b.id_mutasi where a.id_mutasi='$id_mutasi' or b.id_mutasi='$id_mutasi'";
        return $this->db->row($sql_cek);
    }

    public function cekId($table, $nameRow, $id) {
        $sql_cek = "select * from $table where $nameRow = '$id'";
        return $this->db->row($sql_cek);
    }

    public function cekRowCount($table, $nameRow, $id) {
        $sql_cek = "select count($nameRow) as count from $table where $nameRow = '$id'";
        return $this->db->row($sql_cek);
    }

    public function deleteRow($table, $nameRow, $value) {
        $sql_cek = "delete from $table where $nameRow = '$value'";
        return $this->db->row($sql_cek);
    }

    public function cekIdMutasi($id_mutasi) {
        $sql_cek = "select * from tbl_mutasi where id_mutasi = '$id_mutasi';";
        return $this->db->row($sql_cek);
    }

    public function cekIdPekerjaan($id_pekerjaan) {
        $sql_cek = "select * from tbl_pekerjaan where id_pekerjaan = '$id_pekerjaan';";
        return $this->db->row($sql_cek);
    }

    public function cekKonfig($konfig) {
        $qcek_for_inq = "select * from tbl_konfigurasi where konfig = '$konfig' order by id limit 1;";
        $arr = $this->db->row($qcek_for_inq);
        return $arr->setting;
    }

    public function cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip) {
        $ftime = $time_sess != 0 ? "and last_used > now() - interval '$time_sess minutes'" : '';
        $qcek_login = "select id,alias,ip from tbl_member_channel "
                . "where token = '$token' and status = 1 and appid = '$appid' "
                . "and noid = '$noid' and interface = '$interface' and alias = '$username' "
                . "$ftime;";

        $arr = $this->db->row($qcek_login);
        if (!isset($arr->alias)) {
            $this->error->invalidSession();
        } else {
            if ($ip == 'X' || strpos($ip, $arr->ip) !== false || substr($ip, 0, 5) == substr($arr->ip, 0, 5)) {
                $this->db->row("update tbl_member_channel set last_used = now() where id = $arr->id;");
            } else {
                $this->error->invalidIp();
            }
        }
    }

    public function cekSessionH2h($noid, $interface, $username, $token, $appid, $time_sess, $ip) {
        $ftime = "";//$time_sess != 0 ? "and last_used > now() - interval '$time_sess minutes'" : '';
        $qcek_login = "select id,alias,ip from tbl_member_channel "
                . "where token = '$token' and status = 1 and appid = '$appid' "
                . "and noid = '$noid' and interface = '$interface' and alias = '$username' "
                . "$ftime;";

        $arr = $this->db->row($qcek_login);
        if (!isset($arr->alias)) {
            $this->error->invalidSession();
        } else {
            if ($ip == 'X' || strpos($ip, $arr->ip) !== false || substr($ip, 0, 5) == substr($arr->ip, 0, 5)) {
                $this->db->row("update tbl_member_channel set last_used = now() where id = $arr->id;");
            } else {
                $this->error->invalidIp();
            }
        }
    }

    public function cekSessionMulti($noid, $interface, $username, $token, $time_sess) {
        $ftime = $time_sess != 0 ? "and last_used > now() - interval '$time_sess minutes'" : '';
        $qcek_login = "select id,alias,ip from tbl_member_channel "
                . "where token = '$token' and status = 1 "
                . "and noid = '$noid' and interface = '$interface' and alias = '$username' "
                . "$ftime;";

        $arr = $this->db->row($qcek_login);
        if (!isset($arr->alias)) {
            $this->error->invalidSession();
        } else {
            
        }
    }

    public function cekSessionDevice($noid, $interface, $username, $token, $time_sess, $ip) {
        $ftime = $time_sess != 0 ? "and last_used > now() - interval '$time_sess minutes'" : '';
        $qcek_login = "select id,alias,ip from tbl_member_channel "
                . "where status = 1 and substring(token from 1 for 5) = '$token' "
                . "and noid = '$noid' and interface = '$interface' and alias = '$username' "
                . "$ftime;";

        $arr = $this->db->row($qcek_login);
        if (!isset($arr->alias)) {
            $this->error->invalidSession();
        } else {
            if ($ip == 'X' || strpos($ip, $arr->ip) !== false) {
                $this->db->row("update tbl_member_channel set last_used = now() where id = $arr->id;");
            } else {
                $this->error->invalidIp();
            }
        }
    }

    public function cekLogTrx($noid, $traceId, $reff) {
        $qcek_for_inq = "select * from log_channel_trx where status = 0 and date(waktu) = date(now()) "
                . "and noid = '$noid' and trace_id = '$traceId' and reff = '$reff' and response_code = '0000' limit 1;";
        return $this->db->row($qcek_for_inq);
    }

    public function updateLogTrx($id) {
        $qcek_for_inq = "update log_channel_trx set status = 1 where id=$id;";
        $this->db->row($qcek_for_inq);
    }

    public function cekProdukMap($product, $product_detail) {
        $qcek_for_inq = "select id,biller,kode_h2h,status from tbl_product_map where product = '$product' and "
                . "product_detail = '$product_detail' limit 1;";
        return $this->db->row($qcek_for_inq);
    }

    public function cekProdukPulsa($operator, $noid) {
        $noid_m1 = substr($noid, 0, 3) . '0000000000000';
        $noid_m2 = substr($noid, 0, 7) . '000000000';
        $sql_member = "select noid,fee from tbl_member_account where noid='$noid' or "
                . "noid='$noid_m2' or noid='$noid_m1' order by noid asc;";
        $result_member = $this->db->results($sql_member);
        $arr_fee_m1 = json_decode($result_member[0]->fee);
        $arr_fee_m2 = json_decode($result_member[1]->fee);
        $arr_fee_m3 = json_decode($result_member[2]->fee);

        //Margin Pusat dan data produk
        $sql = "select * from tbl_product_map where provider = '$operator' and status = 1 order by hpp asc;";
        $result = $this->db->results($sql);
        $data = array();
        $i=0;
        if (isset($result[0]->id)) {
            foreach ($result as $fetch) {
                $data[$i]['produk_tipe'] = $fetch->product_detail;
                $fee_m1 = (isset($arr_fee_m1->{$fetch->product . $fetch->product_detail})) ? $arr_fee_m1->{$fetch->product . $fetch->product_detail} : 100;
                $fee_m2 = (isset($arr_fee_m2->{$fetch->product . $fetch->product_detail})) ? $arr_fee_m2->{$fetch->product . $fetch->product_detail} : 100;
                $fee_m3 = (isset($arr_fee_m3->{$fetch->product . $fetch->product_detail})) ? $arr_fee_m3->{$fetch->product . $fetch->product_detail} : 100;
                $data[$i]['M3'] = $fee_m1 + $fee_m2 + $fee_m3 + $fetch->hpp;
                $i++;
            }
        }
        return $data;
    }
    
    public function cekHargaPulsa($product, $product_detail, $noid, $saldo_member) {
        $error = new Libraries\ResponseError;
        $noid_m1 = substr($noid, 0, 3) . '0000000000000';
        $noid_m2 = substr($noid, 0, 7) . '000000000';
        $sql_member = "select noid,fee from tbl_member_account where noid='$noid' or "
                . "noid='$noid_m2' or noid='$noid_m1' order by noid asc;";
        $result_member = $this->db->results($sql_member);
        $arr_fee_m1 = json_decode($result_member[0]->fee);
        $arr_fee_m2 = json_decode($result_member[1]->fee);
        $arr_fee_m3 = json_decode($result_member[2]->fee);

        //Margin Pusat dan data produk
        $sql = "select * from tbl_product_map where product = '$product' and product_detail = '$product_detail' and status = 1 order by hpp asc limit 1;";
        $result = $this->db->row($sql);
        
        if(!isset($result->id)){
            $error->productTidakAda($saldo_member);
        }
        
        $data = array();
        $fee_m1 = (isset($arr_fee_m1->{$product . $product_detail})) ? $arr_fee_m1->{$product . $product_detail} : 100;
        $fee_m2 = (isset($arr_fee_m2->{$product . $product_detail})) ? $arr_fee_m2->{$product . $product_detail} : 100;
        $fee_m3 = (isset($arr_fee_m3->{$product . $product_detail})) ? $arr_fee_m3->{$product . $product_detail} : 100;
        $data['harga'] = $fee_m1 + $fee_m2 + $fee_m3 + $result->hpp;
        $data['biller'] = $result->biller;
        $data['kode_h2h'] = $result->kode_h2h;
        $data['margin'] = $fee_m1;
        $data['M1'] = $fee_m2;
        $data['M2'] = $fee_m3;
        $data['operator'] = $result->provider;
        
        return $data;
    }
    
    public function cekHargaAdmin($product, $product_detail, $noid, $saldo_member, $admin_bank) {
        $error = new Libraries\ResponseError;
        $noid_m1 = substr($noid, 0, 3) . '0000000000000';
        $noid_m2 = substr($noid, 0, 7) . '000000000';
        $sql_member = "select noid,fee from tbl_member_account where noid='$noid' or "
                . "noid='$noid_m2' or noid='$noid_m1' order by noid asc;";
        $result_member = $this->db->results($sql_member);
        $arr_fee_m1 = json_decode($result_member[0]->fee);
        $arr_fee_m2 = json_decode($result_member[1]->fee);
        $arr_fee_m3 = json_decode($result_member[2]->fee);

        //Margin Pusat dan data produk
        $sql = "select * from tbl_product_map where product = '$product' and product_detail = '$product_detail' and status = 1 order by hpp asc limit 1;";
        $result = $this->db->row($sql);
        
        if(!isset($result->id)){
            $error->productTidakAda($saldo_member);
        }
        
        $data = array();
        $fee_m1 = (isset($arr_fee_m1->{$product . $product_detail})) ? $arr_fee_m1->{$product . $product_detail} : 100;
        $fee_m2 = (isset($arr_fee_m2->{$product . $product_detail})) ? $arr_fee_m2->{$product . $product_detail} : 100;
        $fee_m3 = (isset($arr_fee_m3->{$product . $product_detail})) ? $arr_fee_m3->{$product . $product_detail} : 100;

        $data['biller'] = $result->biller;
        $data['kode_h2h'] = $result->kode_h2h;
        $data['margin'] = $fee_m1;
        $data['M1'] = $fee_m2;
        $data['M2'] = $fee_m3;
        if($admin_bank < 0){
            $error->adminBankTidakValid($saldo_member);
        }elseif($admin_bank == 1){
            $admin_bank = $result->admin_bank;
        }
        $data['admin_bank'] = $admin_bank;
        $data['M3'] = $admin_bank - ($fee_m1 + $fee_m2 + $fee_m3 + $result->hpp);
        if($data['M3'] < 0){
            $error->adminBankTidakValid($saldo_member);
        }
        
        $data['operator'] = $result->provider;
        
        return $data;
    }
    
    public function cekNoidMember($noid) {
        $sql_cek = "select * from tbl_member_account where noid = '$noid' and status = 1;";
        return $this->db->row($sql_cek);
    }

    public function cekNoidMemberNostat($noid) {
        $sql_cek = "select * from tbl_member_account where noid = '$noid';";
        return $this->db->row($sql_cek);
    }

    public function cekNoidChannel($noid, $interface) {
        $sql_cek = "select * from tbl_member_channel where noid = '$noid' and interface = '$interface';";
        return $this->db->row($sql_cek);
    }

    public function cekIdChannel($id) {
        $sql_cek = "select * from tbl_member_channel where id = $id;";
        return $this->db->row($sql_cek);
    }

    public function cekAliasChannel($alias) {
        $sql_cek = "select * from tbl_member_channel where alias = '$alias';";
        return $this->db->row($sql_cek);
    }

    public function cekNohpMember($nohp) {
        $sql_cek = "select * from tbl_member_account where (nohp_email = '$nohp' OR nohp_email LIKE '%$nohp%') and status = 1;";
        return $this->db->row($sql_cek);
    }

    public function cekNohpMemberReg($nohp) {
        $sql_cek = "select * from tbl_member_account where nohp_email = '$nohp' and jenis = 1;";
        return $this->db->row($sql_cek);
    }

    public function cekNohpChannel($nohp) {
        $sql_cek = "select * from tbl_member_channel where email = '$nohp';";
        return $this->db->row($sql_cek);
    }

    public function kirimMessage($noid, $message) {
        $sql_cek = "select nohp_email from tbl_member_account where noid = '$noid';";
        $arr_nohp = $this->db->row($sql_cek);

        if (isset($arr_nohp->nohp_email)) {
            $nohp = $arr_nohp->nohp_email;
            if (is_numeric($nohp) == TRUE) {
                $jenis_msg = 'SMS';
            } else {
                $jenis_msg = 'EMAIL';
            }
            $sql = "insert into log_message(waktu,nohp_email,noid,interface,msg,stat) "
                    . "values (NOW(),'$nohp','$noid','$jenis_msg','$message',0);";
            $this->db->row($sql);
        }
    }

    public function kirimMessageUnreg($nohp, $message) {

        if (is_numeric($nohp) == TRUE) {
            $jenis_msg = 'SMS';
        } else {
            $jenis_msg = 'EMAIL';
        }
        $sql = "insert into log_message(waktu,nohp_email,noid,interface,msg,stat) "
                . "values (NOW(),'$nohp','$nohp','$jenis_msg','$message',0);";
        $this->db->row($sql);
    }

    public function cekGroupKolektif($noid, $nama) {
        $sql_cek = "select * from tbl_group_kolektif where nama = '$nama' and noid = '$noid';";
        return $this->db->row($sql_cek);
    }

    public function cekDetailKolektif($id_group, $idpel) {
        $sql_cek = "select * from tbl_group_kolektif_detail where id_group = '$id_group' and idpel = '$idpel';";
        return $this->db->row($sql_cek);
    }

    public function cekjangkaWaktu($id_kredit) {
        $sql_cek = "SELECT id_kredit,jangka_waktu FROM tbl_kredit where id_kredit ='$id_kredit'";
        return $this->db->row($sql_cek);
    }

    public function getSingledataAngsuran($id_pinjaman) {
        $sql_cek = "SELECT * FROM tbl_kredit_detail "
                . "where status = '0' and id_tbl_kredit ='$id_pinjaman' "
                . "ORDER BY angsuran_ke asc limit 1";
        return $this->db->row($sql_cek);
    }

    public function cekTotalInvestasi($id_tbl_kredit) {
        $sql_cek = "SELECT id_tbl_kredit,sum(nominal_dana) FROM tbl_kredit_dana "
                . "where id_tbl_kredit = '$id_tbl_kredit' "
                . "GROUP BY id_tbl_kredit;";
        return $this->db->row($sql_cek);
    }
    
    public function cekIdAct($id) {
        $sql_cek = "select * from tbl_act_card where id = 'id';";
        return $this->db->row($sql_cek);
    }

    public function getSetting($setting_name){
        $sql_cek = "SELECT setting_value FROM app_setting WHERE setting_name = '$setting_name'";        
        $data    = $this->db->row($sql_cek);
        if(isset($data->setting_value)){
            return $data->setting_value;    
        }else{
            return 'no';
        }
        
    }
    
    public function doInsertDetailJurnal($id_jurnal, $noid, $nama, $debit_kredit, $nominal){
        if($debit_kredit == "K"){
            $debit = 0;
            $kredit = $nominal;
        }else if($debit_kredit == "D"){
            $debit = $nominal;
            $kredit = 0;
        }
        $sql = "INSERT INTO tbl_jurnal_detail (jurnal_id, noid, nama, debit_kredit, debit, kredit) "
                . "VALUES ('$id_jurnal', '$noid', '$nama', '$debit_kredit' ,'$debit' ,'$kredit') RETURNING id;";
        
        $insert = $this->db->row($sql);
        if(isset($insert->id)){
            return true;
        }else{
            return false;
        }
    }
    
    public function deleteJurnal($id_jurnal){
        $this->db->row("DELETE FROM tbl_jurnal WHERE id = $id_jurnal");
        $this->db->row("DELETE FROM tbl_jurnal_detail WHERE jurnal_id = $id_jurnal");
    }


}
