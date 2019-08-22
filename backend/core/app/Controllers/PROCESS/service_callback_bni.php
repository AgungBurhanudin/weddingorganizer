<?php

$dbVa = new Models\DbVa();
$dbSekolah = new Models\DbSekolah();
$nomor_va       = trim($jreq->detail->nova);
$action         = $jreq->detail->action; //inq exec
$noid_add       = $jreq->detail->noid;
$amount_add     = $jreq->detail->nominal;
$keterangan_add = strtoupper($jreq->detail->keterangan);
$tujuan_add     = strtoupper($jreq->detail->tujuan);

$arr_cek_va = $dbVa->cekNomorVaBnis($nomor_va);

if (!isset($arr_cek_va->id)) {
    $error->accountTidakAda($saldo_member);
}
if ($arr_cek_va->noid != $noid_add) {
    $error->accountTidakAda($saldo_member);
}

if ($arr_cek_va->jenis == 0) {
    //open payment atau top up saldo
    //top up saldo member
    $arr_cek_mbr = $db->cekNoidMember($noid_add);

    if (!isset($arr_cek_mbr->id)) {
        $error->accountTidakAda($saldo_member);
    }
    $noid_add       = $arr_cek_mbr->noid;
    $nama_add       = $arr_cek_mbr->nama;
    $tipe_add       = $arr_cek_mbr->tipe;
    $nohp_email_add = $arr_cek_mbr->nohp_email;

//    if ($noid_add == $noid) {
//        $error->accountTidakValid($saldo_member);
//    }

    if ($amount_add < 100) {
        $error->minimalTransaksi($saldo_member);
    }

    $aturan = $tipe_member . $tipe_add;

    if ($aturan == 'ADMINM1' || $aturan == 'ADMINM2' || $aturan == 'ADMINM3') {

        if (($saldo_member < $amount_add) && $tipe_member != 'ADMIN') {
            $error->tipeActionTidakValid($saldo_member);
        } else {
            $amount_minus = $amount_add * -1;
            $data_trx     = array(
                'username'         => $username,
                'interface'        => $interface,
                'product'          => 'TOPUP',
                'product_detail'   => 'SALDO',
                'idpel'            => $noid_add,
                'idpel_name'       => $nama_add,
                'amount'           => $amount_add,
                'keterangan'       => $keterangan_add,
                'bank'             => $tujuan_add,
                'reff'             => $ref,
                'trace_id'         => $ref,
                'lembar'           => 1,
                'response_code'    => '0000',
                'response_message' => 'sukses',
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
                $saldo_noid       = $db->singleRow($sql_kurang_saldo);
                $saldo_last       = $saldo_noid->saldo;
            }
            $data_trx_add = array(
                'username'         => $nama_member,
                'interface'        => $interface,
                'product'          => 'TOPUP',
                'product_detail'   => 'SALDO',
                'idpel'            => $noid,
                'idpel_name'       => $nama_member,
                'amount'           => $amount_add,
                'keterangan'       => $keterangan_add,
                'bank'             => $tujuan_add,
                'reff'             => $ref,
                'trace_id'         => $ref,
                'lembar'           => 1,
                'response_code'    => '0000',
                'response_message' => 'sukses',
            );
            $jlast_trx_noid   = json_encode($data_trx_add);
            $sql_tambah_saldo = "update tbl_member_account set saldo = saldo + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo;";
            $saldo_add        = $db->singleRow($sql_tambah_saldo);
            $saldo_add_last   = $saldo_add->saldo;

            //Biaya Admin
            $biaya_admin       = $db->getSetting('biaya_admin');
            $biaya_admin_minus = $biaya_admin * -1;
            $keterangan_admin  = "Biaya Admin Top Up ";

            //Masuk ke saldo user pegawai finance, tapi siapa user pegawai finance nya?
            $noid_finance     = "0000000000020001";
            $nama_finance     = "FINANCE";
            $data_biaya_admin = array(
                'username'         => $nama_finance,
                'interface'        => $interface,
                'product'          => 'TOPUP',
                'product_detail'   => 'BIAYA_ADMIN',
                'idpel'            => $noid_finance,
                'idpel_name'       => $nama_finance,
                'amount'           => $biaya_admin,
                'keterangan'       => $keterangan_admin,
                'bank'             => "",
                'reff'             => $ref,
                'trace_id'         => $ref,
                'lembar'           => 1,
                'response_code'    => '0000',
                'response_message' => 'sukses',
            );
            $jlast_trx_biaya_admin = json_encode($data_biaya_admin);
            if ($tipe_member == 'ADMIN') {
                $saldo_last = 0; //karena ADMIN saldo unlimit
                //sql_insert manual
                $sql_insert_manual = "insert into log_data_trx (waktu,noid,reff,amount,saldo,detail) "
                    . "values (now(),'$noid','$ref','$biaya_admin','$saldo_last','$jlast_trx_biaya_admin');";
                $db->singleRow($sql_insert_manual);
            } else {
                $sql_kurang_saldo = "update tbl_member_account set saldo = saldo + $biaya_admin,last_trx='$jlast_trx_biaya_admin',last_amount='$biaya_admin',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo;";
                $saldo_noid       = $db->singleRow($sql_kurang_saldo);
                $saldo_last       = $saldo_noid->saldo;
            }

            //Mengurangi Saldo Member nya
            $data_biaya_admin_add = array(
                'username'         => $nama_member,
                'interface'        => $interface,
                'product'          => 'TOPUP',
                'product_detail'   => 'BIAYA_ADMIN',
                'idpel'            => $noid,
                'idpel_name'       => $nama_member,
                'amount'           => $biaya_admin_minus,
                'keterangan'       => $keterangan_admin,
                'bank'             => "",
                'reff'             => $ref,
                'trace_id'         => $ref,
                'lembar'           => 1,
                'response_code'    => '0000',
                'response_message' => 'sukses',
            );
            $jlast_trx_biaya_admin_noid = json_encode($data_biaya_admin_add);
            $sql_tambah_saldo           = "update tbl_member_account set saldo = saldo + $biaya_admin_minus,last_trx='$jlast_trx_biaya_admin_noid',last_amount=$biaya_admin_minus,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo;";
            $saldo_add                  = $db->singleRow($sql_tambah_saldo);
            $saldo_add_last             = $saldo_add->saldo;
            
            //Tambahan Insert Ke Jurnal
            $result = true;
            $tanggal = date('Y-m-d');
            $waktu   = date('H:i:s');
            $insert = $db->singleRow("INSERT INTO tbl_jurnal (transaksi, tanggal, waktu, keterangan, kode) "
                    . "VALUES ('TOP UP SALDO MELALUI VA', '$tanggal', '$waktu', 'NO VA $nomor_va', '$ref') RETURNING id;");
            if(isset($insert->id)){
                $result = $result && true;
                $id_jurnal = $insert->id;
                //Add Saldo Ke User
                $noid_ortu = $jreq->detail->noid;
                $noid_user = $jreq->noid;
                $noid_m2 = substr($noid_ortu,0,7) . "000000000";
                
                $arr_sekolah = $db->cekId('tbl_act_card','noid',$noid_m2);
                $kode_sekolah = $arr_sekolah->alias_act;
                
                $arr_sekolah2 = $dbSekolah->cekId('tbl_sekolah','kode_sekolah', $kode_sekolah);
                $noid_padanan_admin = $arr_sekolah2->noid_admin;
                $id_sekolah = $arr_sekolah2->id;
                $update_id = $db->singleRow("UPDATE tbl_jurnal SET kode_sekolah = '$id_sekolah' where id = $id_jurnal;");
                
                
                $arr_member_account_ortu = $db->cekId('tbl_member_account','noid',$noid_ortu);
                $arr_member_account_user = $db->cekId('tbl_member_account','noid',$noid_user);
                $arr_member_account_sklh = $db->cekId('tbl_member_account','noid',$noid_m2);
                $arr_member_account_pdnn = $db->cekId('tbl_member_account','noid',$noid_padanan_admin);
                
                //Nominal
                $nominal           = $jreq->detail->nominal;
                $biaya_admin       = $db->getSetting('biaya_admin');
                $sisa              = $nominal - $biaya_admin;
                
                //Kredit ke Akun Sekolah                
                $result = $result && $db->doInsertDetailJurnal($id_jurnal, $noid_m2, $arr_member_account_sklh->nama, 'K', $nominal);
                //Debit ke Akun Orang Tua atau yang topup nominal dikurangi biaya admin
                $result = $result && $db->doInsertDetailJurnal($id_jurnal, $noid_ortu, $arr_member_account_ortu->nama, 'D', $sisa);
                //Debit ke Padanan Admin M2
                $result = $result && $db->doInsertDetailJurnal($id_jurnal, $noid_padanan_admin, $arr_member_account_pdnn->nama, 'D', $biaya_admin);
            }
            
            
            $response = array(
                'response_code'    => '0000',
                'saldo'            => $saldo_last,
                'response_message' => "TOPUP SALDO KE $noid_add a.n $nama_add Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL. REFF : $ref",
                'trace_id'         => $ref,
            );

            $msg_out = $konfig->namaAplikasi() . ", TOPUP SALDO MELALUI VIRTUAL ACCOUNT BNI $nomor_va Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL REFF $ref. Saldo Rp. " . $fungsi->rupiah($saldo_add_last);
            $db->kirimMessage($noid_add, $msg_out);
        }
    } else {
        $error->accountTidakValid($saldo_member);
    }
} else {
    //1 pembayaran tagihan
    $arr_cek_tgh = $dbVa->cekIdTagihan($noid_add);
    if (!isset($arr_cek_tgh->id)) {
        $error->accountTidakAda($saldo_member);
    }
    //update tabel tagihan
    $noid_creator = $arr_cek_tgh->noid;
    //1 ada masuk, 2 lunas, 3 kelebihan
    if ($arr_cek_tgh->total_tagihan == $amount_add) {
        $status_pay = 2;
    } else {
        $status_pay = 1;
    }
    $sql_update = "update tbl_tagihan set saldo = saldo + $amount_add, waktu_bayar = now(), vsn = '$ref', status = $status_pay "
        . "where id=$arr_cek_tgh->id;";
    $dbVa->singleRow($sql_update);

    $response = array(
        'response_code'    => '0000',
        'saldo'            => $saldo_member,
        'response_message' => "Pembayaran Tagihan $arr_cek_tgh->jenis_tagihan $noid_add dengan Nomor VA $nomor_va Rp " . $fungsi->rupiah($amount_add) . " BERHASIL. REFF : $ref",
    );
    $db->kirimMessage($arr_cek_tgh->noid, "Pembayaran Tagihan $arr_cek_tgh->jenis_tagihan $noid_add dengan Nomor VA $nomor_va Rp " . $fungsi->rupiah($amount_add) . " BERHASIL. REFF : $ref");
}
$reply = json_encode($response);
