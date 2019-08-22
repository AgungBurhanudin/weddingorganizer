<?php

namespace Controllers;

use Resources,
    Models,
    Libraries;

class SERVICE extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        $this->rest = new Resources\Rest;
    }

    public function coba() {
        $interface = 'COBA';
        $name = 'trial';
        $request = 'hello word';
        date_default_timezone_set("Asia/Bangkok");
        $tgl = date("Y-m-d");
        //$path = 'C:\\logs\\';
        $path = '/var/www/log_request/';
	$path = '/usr/share/nginx/html/framework/public/photoIdentity/';
        if (!is_dir($path . $tgl)) {
            mkdir($path.$tgl, 0777, true);
        }
        //aneh
        $filename = $path.$tgl.'/'.$interface . '_' . $name . '.txt';
        $fh = fopen($filename, "a") or fopen($filename, "w");
        fwrite($fh, date("d-m-Y, H:i") . "\n$request\n\n") or die("Could not write file!");
        fclose($fh);
    }

    public function setting_product($token, $noid) {
        $db = new Models\Databases();
        if ($token == 'piewuroijlkjdio3892iolkejwoi938iuewi') {

            $sql_member = "select fee from tbl_member_account where noid='$noid'";
            $result_member = $db->singleRow($sql_member);
            $arr_fee = json_decode($result_member->fee);

            $sql = "select product,product_detail,default_margin from tbl_product_map "
                    . "order by product,product_detail;";
            $result = $db->multipleRow($sql);
            $setting_fee = array();
            if (isset($result[0]->product)) {
                foreach ($result as $fetch) {
                    if (isset($arr_fee->{$fetch->product . $fetch->product_detail})) {
                        $setting_fee[$fetch->product . $fetch->product_detail] = $arr_fee->{$fetch->product . $fetch->product_detail};
                    } else {
                        $setting_fee[$fetch->product . $fetch->product_detail] = $fetch->default_margin;
                    }
                }
                echo json_encode($setting_fee);
            } else {
                echo '{}';
            }
        } else {
            echo 'invalid token';
        }
    }

    public function list_message($tipe, $token) {
        $db = new Models\Databases();        
        $send_message = $db->getSetting('send_message');
        if ($token == 'piewuroijlkjdio3892iolkejwoi938iuewi') {
            $nohp_email = 'nohp_email';
            if ($tipe == 'SMS') {
                $nohp_email = 'nohp_email as nohp';
            }
            $sql = "select id,waktu,$nohp_email,msg from log_message "
                    . "where stat = 0 and interface='$tipe' order by id;";
            $result = $db->multipleRow($sql);

            if (isset($result[0]->id)) {
                foreach ($result as $fetch) {
                    $sql_update = "update log_message set stat=1 where id = $fetch->id";
                    $db->singleRow($sql_update);
                }
                if($send_message == "yes"){
                    echo json_encode($result);    
                }else{
                    echo '[]';
                }
                
            } else {
                echo '[]';
            }
        } else {
            echo 'invalid token';
        }
    }

    public function service_add_va_bni($token) {
        $db = new Models\Databases();
        $dbVa = new Models\DbVa();
        $konfig = new Libraries\Konfigurasi;

        if ($token == 'piewuroijlkjdio3892iolkejwoi938iuewi') {

            $sql = "select m3.id, m3.noid, m3.nama, m3.nohp_email, m3.jva, m3.noid_act, m3.noid_mit, m2.nama as nama_sekolah, m2.is_flexible from tbl_member_account m3 "
                ."inner join tbl_member_account m2 on m3.noid_act = m2.noid "
                ."where m3.jenis=1 and m3.tipe='M3' and m3.jva::jsonb->>'BNI'='0' and m2.is_flexible=0 order by id;";
            $result = $db->multipleRow($sql);
            $url = "http://dsyariah.co.id/tki/va/create_open_va.php";
            $email = "";
            if (isset($result[0]->id)) {
                foreach ($result as $fetch) {
                    $arrNohp = explode("#", $fetch->nohp_email);
                    $nohp = $fetch->nohp_email;
                    if (strpos($nohp, '#') !== false) {
                        foreach ($arrNohp as $strNohp) {
                            if (is_numeric($strNohp) && strlen($strNohp)>10) {
                                $nohp = $strNohp;
                                break;
                            }
                        }
                    }
                    
                    if (is_numeric($nohp) && strlen($nohp)>10) {
                        $email = '';
                        $sql_insert = "insert into tbl_nomor_va_bnis (noid,bank,keterangan) values ('$fetch->noid','BNI','insert') returning id";
                        $arr_insert = $dbVa->singleRow($sql_insert);
                        $id_va = $nohp;
                        
                        echo $request = '{"noid": "' . $fetch->noid . '",'
                        . '"nohp": "' . $id_va . '",'
                        . '"nama": "' . $fetch->nama . '",'
                        . '"email": "' . $email . '",'
                        . '"app": "PSP",'
                        . '"nominal":0}';
                        //tembak service va
                        $contents = $this->rest->sendRequest($url, 'POST', $request);
//$contents = str_replace("PSP","",$contents);
//$contents = json_encode($contents);
//print_r($contents);
//                        $contents = '{"status": "0000","virtual_account": "VA' . $id_va . '"}';

                        $jrespon = json_decode($contents);
//echo $contents;
//echo "123";
//exit();
//die();
//print_r($jrespon);  
                      if ($jrespon->status == '0000') {
                            $sql_update = "update tbl_nomor_va_bnis set nomor_va='$jrespon->virtual_account',keterangan='$fetch->nama' where id=$arr_insert->id;";
                            $jva = json_decode($fetch->jva);
                            $jva->BNI = $jrespon->virtual_account;
                            $string_jva = json_encode($jva);
                            $sql_update_mb = "update tbl_member_account set jva = '$string_jva' where id = $fetch->id;";
                            $db->singleRow($sql_update_mb);
                            $msg_out = $konfig->namaAplikasi() . ", NOMOR VA BNI (009), Untuk TOPUP SALDO ke No Rekening BNI : " . $jrespon->virtual_account . " a.n " . $fetch->nama;
                            $db->kirimMessage($fetch->noid, $msg_out);
                        } else {
                            $sql_update = "update tbl_nomor_va_bnis set nomor_va='ERROR',keterangan='$fetch->nama' where id=$arr_insert->id;";
                            $jva = json_decode($fetch->jva);
                            $jva->BNI = 'ERROR';
                            $string_jva = json_encode($jva);
                            $sql_update_mb = "update tbl_member_account set jva = '$string_jva' where id = $fetch->id;";
                            $db->singleRow($sql_update_mb);
                            $msg_out = $konfig->namaAplikasi() . ", NOMOR VA BNI (009) masih dalam proses, silahkan hubungi customer service.";
                            $db->kirimMessage($fetch->noid, $msg_out);
                        }
                        $dbVa->singleRow($sql_update);
                        echo "ok";
                        break;
                    }else{
                        echo "Nohp tidak valid";
                    }
                }
            } else {
                echo 'tidak ada data';
            }
        } else {
            echo 'invalid token';
        }
    }

    public function refresh_today_trx($token) {
        $db = new Models\Databases();
        if ($token == 'piewuroijlkjdio3892iolkejwoi938iuewi') {
            $sql = "update tbl_member_account set today_trx = 0;"
                    . "update tbl_member_channel set today_trx = 0";
            $result = $db->singleRow($sql);
            echo 'ok';
        } else {
            echo 'invalid token';
        }
    }

    public function refresh_limit_trx($token) {
        $db = new Models\Databases();
        $akumulasi = $db->getSetting("limit_akumulasi");
        if ($token == 'piewuroijlkjdio3892iolkejwoi938iuewi') {
            if($akumulasi == "yes"){
                $sql = "update tbl_member_account set limit_saldo = 0;"
                        . "update tbl_member_channel set limit_trx = set_limit_trx, akumulasi_limit = ''";
                $result = $db->singleRow($sql);
            }else{
                $sql = "update tbl_member_account set limit_saldo = 0;"
                        . "update tbl_member_channel set limit_trx = set_limit_trx";
                $result = $db->singleRow($sql);
            }
            echo 'ok';
        } else {
            echo 'invalid token';
        }
    }

    public function posting_data($token) {
        $db = new Models\Databases();
        if ($token == 'piewuroijlkjdio3892iolkejwoi938iuewi') {
            $sql = "update tbl_member_account set today_trx = 0;"
                    . "update tbl_member_channel set today_trx = 0";
            $result = $db->singleRow($sql);
            echo 'ok';
        } else {
            echo 'invalid token';
        }
    }

    public function backup_channel_trx($token) {
        $db = new Models\Databases();
        if ($token == 'piewuroijlkjdio3892iolkejwoi938iuewi') {
            $sql = "update tbl_member_account set today_trx = 0;"
                    . "update tbl_member_channel set today_trx = 0";
            $result = $db->singleRow($sql);
            echo 'ok';
        } else {
            echo 'invalid token';
        }
    }

    public function proses_tiket_deposit($token) {
        $db = new Models\Databases();
        $fungsi = new Libraries\Fungsi();
        $konfig = new Libraries\Konfigurasi;
        if ($token == '893U489HOUEW9823U8W73U8W89381JN') {
            $sql = "select id,waktu,bank,ket,nominal,dc,waktu_bank,saldo,executed,noid "
                    . "from bank_capture where executed=0 and date(waktu) = date(now()) order by id;";
            $result = $db->multipleRow($sql);
            if (isset($result[0]->id)) {
                foreach ($result as $fetch) {

                    $nominal = $fetch->nominal;
                    $bank = $fetch->bank;
                    $keterangan = $fetch->ket;
                    $action = 'exec'; //inq exec
                    $bukti_add = $keterangan;
                    $sql_cek_konf = "select * from log_konfirmasi_topup where nominal = $nominal and bank = '$bank' "
                            . "and status = 0 and date(waktu) = date(now()) order by id desc limit 1;";
                    $arr_cek_konf = $db->singleRow($sql_cek_konf);

                    if (isset($arr_cek_konf->id)) {
                        $id_add = $arr_cek_konf->id;
                        $noid_add = $arr_cek_konf->noid;
                        $amount_add = $arr_cek_konf->nominal;
                        $reff_add = $arr_cek_konf->reff;
                        $tujuan_add = $arr_cek_konf->bank;
                        $keterangan_add = $arr_cek_konf->keterangan;

                        $arr_cek_mbr = $db->cekNoidMember($noid_add);

                        if (!isset($arr_cek_mbr->id)) {
                            $error->accountTidakAda(0);
                        }
                        $noid_add = $arr_cek_mbr->noid;
                        $nama_add = $arr_cek_mbr->nama;
                        $tipe_add = $arr_cek_mbr->tipe;
                        $nohp_email_add = $arr_cek_mbr->nohp_email;

                        $interface = 'ROBOT';
                        $tipe_member = 'ADMIN';
                        $noid = '0000000000010001';
                        $nama_member = 'TIKET_DEPOSIT_' . $bank;
                        $username = $nama_member;
                        $ref = date("ymdH") . $fungsi->randomNumber(8);

                        if ($noid_add == $noid) {
                            $error->accountTidakValid(0);
                        }

                        if ($amount_add < 1000) {
                            $error->minimalTransaksi(0);
                        }

                        $amount_minus = $amount_add * -1;
                        $data_trx = array(
                            'username' => $username,
                            'interface' => $interface,
                            'product' => 'TIKET DEPOSIT',
                            'product_detail' => 'SALDO',
                            'idpel' => $noid_add,
                            'idpel_name' => $nama_add,
                            'amount' => $amount_minus,
                            'keterangan' => $keterangan_add,
                            'bank' => $tujuan_add,
                            'reff' => $ref,
                            'trace_id' => $ref,
                            'lembar' => 1,
                            'response_code' => '0000',
                            'response_message' => 'sukses'
                        );
                        $jlast_trx = json_encode($data_trx);
                        if ($tipe_member == 'ADMIN') {
                            $saldo_last = 0; //karena ADMIN saldo unlimit
                            //sql_insert manual
                            $sql_insert_manual = "insert into log_data_trx (waktu,noid,reff,amount,saldo,detail) "
                                    . "values (now(),'$noid','$ref','$amount_minus','$saldo_last','$jlast_trx');";
                            $db->singleRow($sql_insert_manual);
                        } else {
                            $sql_kurang_saldo = "update tbl_member_account set saldo = saldo + $amount_minus,last_trx='$jlast_trx',last_amount='$amount_minus',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo;";
                            $saldo_noid = $db->singleRow($sql_kurang_saldo);
                            $saldo_last = $saldo_noid->saldo;
                        }
                        $data_trx_add = array(
                            'username' => $nama_member,
                            'interface' => $interface,
                            'product' => 'TIKET DEPOSIT',
                            'product_detail' => 'SALDO',
                            'idpel' => $noid,
                            'idpel_name' => $nama_member,
                            'amount' => $amount_add,
                            'keterangan' => $keterangan_add,
                            'bank' => $tujuan_add,
                            'reff' => $ref,
                            'trace_id' => $ref,
                            'lembar' => 1,
                            'response_code' => '0000',
                            'response_message' => 'sukses'
                        );
                        $jlast_trx_noid = json_encode($data_trx_add);
                        $sql_tambah_saldo = "update tbl_member_account set saldo = saldo + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo;";
                        $saldo_add = $db->singleRow($sql_tambah_saldo);
                        $saldo_add_last = $saldo_add->saldo;

                        $response = array(
                            'response_code' => '0000',
                            'saldo' => $saldo_last,
                            'response_message' => "Validasi TOPUP Tiket Deposit SALDO KE $noid_add a.n $nama_add Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL. REFF : $ref",
                            'trace_id' => $ref
                        );

                        $msg_out = $konfig->namaAplikasi() . ", TOPUP Tiket Deposit Bank $bank SALDO Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL REFF $ref. Saldo Rp. " . $fungsi->rupiah($saldo_add_last);
                        $db->kirimMessage($noid_add, $msg_out);



                        $sql_update_konf = "update log_konfirmasi_topup set status=1, waktu_proses = now(), "
                                . "noid_executor = '$noid', bukti_transfer = '$bukti_add' where id = $id_add;";
                        $db->singleRow($sql_update_konf);
                    } else {
                        $response = array(
                            'response_code' => '0403',
                            'response_message' => "TOPUP GAGAL, Data Konfirmasi Deposit tidak ditemukan"
                        );
                    }
                    
                    $sql_update = "update bank_capture set executed=1,noid='$noid_add' where id = $fetch->id";
                    $db->singleRow($sql_update);
                    sleep(1);
                }
                echo json_encode($result);
            }
            echo 'ok';
        } else {
            echo 'invalid token';
        }
    }

    
    public function add_jabber($token) {
        $db = new Models\Databases();
        $dbOp = new Models\DbOpenfire();
        if ($token == 'jfpiewoiu98023joyw983u2ouy398228eiu') {
            
            $sql = "select id,noid from tbl_member_account where jabber = 0 order by id;";
            $result = $db->multipleRow($sql);

            if (isset($result[0]->id)) {
                foreach ($result as $fetch) {
                    $sql_update = "update tbl_member_account set jabber=1 where id = $fetch->id";
                    $db->singleRow($sql_update);
                    $sql_insert = "insert into ofuser (username,storedkey,serverkey,salt,iterations,plainpassword,encryptedpassword,name,email,creationdate,modificationdate) "
                            . "values ('$fetch->noid','ks4mleIX69ila/iaL5FouD1p2jM=','fiQInYyl0tAlB71s9cfLua3fY6g=','tjPHsUpiN4PqGXrOJS1PyJmwwbNeuukQ',4096,'','00fffad239f85532fc1d8918d8cdf697dfac5dd1d28ee384d8b248baf9bac1ab7183be9f6fe87d4f5b70b84dfa564d041986fdfd10faccbb','Masdar','','001525664896451','001525664896451')";
                    $dbOp->singleRow($sql_insert);
                }
                echo json_encode($result);
            } else {
                echo '[]';
            }
        } else {
            echo 'invalid token';
        }
    }
    
}
