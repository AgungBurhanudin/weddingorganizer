<?php

$dbSekolah     = new Models\DbSekolah;
$id            = $jreq->detail->id;
$arr           = $dbSekolah->cekId('tbl_tagihan', 'id', $id);
$noid          = $jreq->noid;
$data_member   = $db->cekId('tbl_member_channel', 'noid', $noid);
$id_sekolah    = $data_member->kode_sekolah;
$id_pel        = $arr->id_pel;//$jreq->detail->id_siswa;
$tanggal_bayar = date('Y-m-d');//$jreq->detail->tanggal_bayar;
$total_bayar   = $jreq->detail->total_bayar;
$keterangan    = $jreq->detail->keterangan;

if ($total_bayar >= $saldo_member) {
    $response = array(
        'response_code'    => '0099',
        'response_message' => 'Pembayaran Tagihan Gagal, Saldo Anda tidak cukup',
    );
    die(json_encode($response));
}

if (!empty($arr)) {
    $sisa_tagihan = $arr->sisa_tagihan;
    if ($total_bayar >= $total_bayar) {
        $sisa_tagihan       = $sisa_tagihan - $total_bayar;
        $status             = ($sisa_tagihan == 0) ? 2 : 1;
        $status_pembayaran  = ($sisa_tagihan == 0) ? "paid" : "unpaid";
        $pembayaran_old     = $arr->pembayaran;
        $arr_pembayaran_old = json_decode($pembayaran_old, true);

        $pembayaran[] = array(
            'id_pembayaran' => uniqid(),
            'tanggal_bayar' => $tanggal_bayar,
            'total_bayar'   => $total_bayar,
            'keterangan'    => $keterangan,
            'admin'         => 0,
            'via'           => "WEB",
            'status'	    => $status_pembayaran
        );
        if (!empty($arr_pembayaran_old)) {
            $pembayaran = array_merge($arr_pembayaran_old, $pembayaran);
        }
        $j_pembayaran = json_encode($pembayaran);
        $query        = "UPDATE tbl_tagihan SET sisa_tagihan = '$sisa_tagihan', pembayaran = '$j_pembayaran' , status = '$status' WHERE id = '$id'";
		$dbSekolah->singleRow($query);
        //Pengurangan Saldo Kartu Jajan
        //=================================================
        $cek_m2          = $db->cekId('tbl_member_account', 'noid', $noid);
        $noid_add        = "0010000000000000"; //$cek_m2->noid_act; Hard Code M2 nya siapa, aku bingung goleki M1 M2 M3 mboooooohhhhhhhhhhhhhhhh
        $data_account_m2 = $db->cekId('tbl_member_account', 'noid', $noid_add);
        $data_channel_m2 = $db->cekId('tbl_member_channel', 'noid', $noid_add);
        $amount_add      = $total_bayar;
        $amount_minus    = $amount_add * -1;
        $data_trx        = array(
            'username'         => $username,
            'interface'        => $interface,
            'product'          => 'CASH_OUT',
            'product_detail'   => 'PEMBAYARAN',
            'idpel'            => $noid,
            'idpel_name'       => $nama_member,
            'amount'           => $amount_minus,
            'limit'            => '',
            'keterangan'       => $keterangan,
            'reff'             => $ref,
            'trace_id'         => $ref,
            'lembar'           => 1,
            'response_code'    => '0000',
            'response_message' => 'sukses',
        );
        $jlast_trx = json_encode($data_trx);
        if ($data_account_m2->is_flexible == 1) {
            $sql_kurang_saldo = "update tbl_member_account set saldo_sekolah = saldo_sekolah + $amount_minus,last_trx='$jlast_trx',last_amount='$amount_minus',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo_sekolah as saldo;";
        } else {
            $sql_kurang_saldo = "update tbl_member_account set saldo = saldo + $amount_minus,last_trx='$jlast_trx',last_amount='$amount_minus',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo;";
        }
        // echo "$sql_kurang_saldo";
        $saldo_noid = $db->singleRow($sql_kurang_saldo);
        $saldo_last = $saldo_noid->saldo;

        $data_trx_add = array(
            'username'         => $data_channel_m2->alias,
            'interface'        => $interface,
            'product'          => 'CASH_OUT',
            'product_detail'   => 'PEMBAYARAN',
            'idpel'            => $noid_add,
            'idpel_name'       => $data_account_m2->nama,
            'amount'           => $amount_add,
            'limit'            => '',
            'keterangan'       => $keterangan,
            'reff'             => $ref,
            'trace_id'         => $ref,
            'lembar'           => 1,
            'response_code'    => '0000',
            'response_message' => 'sukses',
        );
        $jlast_trx_noid = json_encode($data_trx_add);
        if ($data_account_m2->is_flexible == 1) {
            $sql_tambah_saldo = "update tbl_member_account set saldo_sekolah = saldo_sekolah + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo_sekolah AS saldo;";
        } else {
            $sql_tambah_saldo = "update tbl_member_account set saldo = saldo + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo;";
        }
        // echo "$sql_tambah_saldo";

        $saldo_add      = $db->singleRow($sql_tambah_saldo);
        $saldo_add_last = $saldo_add->saldo;
        //=================================================

        
            //Tambahan Insert Ke Jurnal
            $result = true;
            $tanggal = date('Y-m-d');
            $waktu   = date('H:i:s');
            $nama_tagihan = $arr->nama_tagihan;

                $noid_ortu = $jreq->noid;
                $noid_m2 = substr($noid_ortu,0,7) . "000000000";
                
                $arr_sekolah = $db->cekId('tbl_act_card','noid',$noid_m2);
                $kode_sekolah = $arr_sekolah->alias_act;
                
                $arr_sekolah2 = $dbSekolah->cekId('tbl_sekolah','kode_sekolah', $kode_sekolah);
                $noid_padanan_admin = $arr_sekolah2->noid_pembayaran;
                $id_sekolah_ = $arr_sekolah2->id;

            $insert = $db->singleRow("INSERT INTO tbl_jurnal (transaksi, tanggal, waktu, keterangan, kode, kode_sekolah) "
                    . "VALUES ('Pembayaran $nama_tagihan', '$tanggal', '$waktu', '$keterangan', '$ref', '$id_sekolah_') RETURNING id;");
            if(isset($insert->id)){
                $result = $result && true;
                $id_jurnal = $insert->id;
                //Add Saldo Ke User
                
                
                $arr_member_account_ortu = $db->cekId('tbl_member_account','noid',$noid_ortu);
                $arr_member_account_sklh = $db->cekId('tbl_member_account','noid',$noid_m2);
                $arr_member_account_pdnn = $db->cekId('tbl_member_account','noid',$noid_padanan_admin);
                
                //Nominal
                $nominal           = $jreq->detail->total_bayar;
                //$biaya_admin       = $db->getSetting('biaya_admin');
                //$sisa              = $nominal - $biaya_admin;
                
                //Kredit ke Akun Orang Tua                
                $result = $result && $db->doInsertDetailJurnal($id_jurnal, $noid_ortu, $arr_member_account_ortu->nama, 'K', $nominal);
                //Debit ke Padanan Pembayaran M2
                $result = $result && $db->doInsertDetailJurnal($id_jurnal, $noid_padanan_admin, $arr_member_account_pdnn->nama, 'D', $nominal);
            }
            
        // $dbSekolah->singleRow($query);
        $response = array(
            'response_code'    => '0000',
            'saldo'            => $saldo_last,
            'struk'            => 'struk',
            'response_message' => "Pembayaran Sebesar Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL. REFF : $ref",
            'trace_id'         => $ref,
        );
    } else {
        $response = array(
            'response_code'    => '0099',
            'response_message' => 'Total Pembayaran lebih dari sisa tagihan',
        );
    }
} else {
    $response = array(
        'response_code'    => '0099',
        'response_message' => 'Pembayaran Tagihan Gagal, Data Tagihan tidak di temukan',
    );
}

$reply = json_encode($response);
