<?php

$action         = $jreq->detail->action; //inq exec
$alias_add      = strtoupper($jreq->detail->alias);
$passw_add      = strtoupper($jreq->detail->passw);
$amount_add     = $jreq->detail->nominal;
$keterangan_add = strtoupper($jreq->detail->keterangan);

$sql_cek_kartu = "select id,noid,nama,limit_trx - today_trx as limit_trx,passw,appid from "
    . "tbl_member_channel where email = '$alias_add' order by id limit 1;";
$arr_cek_kartu = $db->singleRow($sql_cek_kartu);

if (isset($arr_cek_kartu->id)) {
    $id_chan   = $arr_cek_kartu->id;
    $noid_add  = $arr_cek_kartu->noid;
    $limit_trx = $arr_cek_kartu->limit_trx;
    $passw     = $arr_cek_kartu->passw;

    if ($limit_trx <= $amount_add) {
        $response = array(
            'response_code'    => '0404',
            'response_message' => 'GAGAL, LIMIT TRANSAKSI HARIAN TIDAK MENCUKUPI. SISA LIMIT RP. ' . $fungsi->rupiah($limit_trx),
            'saldo'            => $saldo_member,
        );
        die(json_encode($response));
    }

    $arr_cek_mbr = $db->cekNoidMember($noid_add);
    if (!isset($arr_cek_mbr->id)) {
        $error->accountTidakAda($saldo_member);
    }
    $arr_m2         = $db->cekId('tbl_member_account', 'noid_act', $noid_add);
    $noid_add       = $arr_cek_mbr->noid;
    $nama_add       = $arr_cek_kartu->nama;
    $tipe_add       = $arr_cek_mbr->tipe;
    $nohp_email_add = $arr_cek_mbr->nohp_email;

    if ($noid_add == $noid) {
        $error->accountTidakValid($saldo_member);
    }
    if ($amount_add < 500) {
        $error->minimalTransaksi($saldo_member);
    }

//LANJUUUT
    $aturan = $tipe_member . $tipe_add;
    if ($aturan == 'M2M3' || $aturan == 'M3M3') {
        if ($action == 'inq') {
            $response = array(
                'response_code'    => '0000',
                'saldo'            => $saldo_member,
                'response_message' => "Apakah anda ingin melakukan Cash Out atas nama $nama_add Rp. " . $fungsi->rupiah($amount_add) . " ?",
            );
            die(json_encode($response));
        } elseif ($action == 'exec') {
            $response = array(
                'response_code'    => '0000',
                'saldo'            => $saldo_member,
                'response_message' => "Tunggu Proses Otorisasi oleh pelanggan ... Jika lebih dari 60 detik, kirim reversal",
            );
            //insert into log_otorisasi.. trus tunggu pembeli update database utk otorisasi..
            $new_limit    = $limit_trx - $amount_add;
            $amount_minus = $amount_add * -1;
            $data_trx     = array(
                'username'         => $nama_member,
                'interface'        => $interface,
                'product'          => 'CASH_OUT',
                'product_detail'   => 'SALDO',
                'idpel'            => $noid,
                'idpel_name'       => $nama_member,
                'amount'           => $amount_minus,
                'limit'            => $new_limit,
                'keterangan'       => $keterangan_add,
                'reff'             => $ref,
                'trace_id'         => $ref,
                'lembar'           => 1,
                'response_code'    => '0000',
                'response_message' => 'sukses',
            );
            $jlast_trx = json_encode($data_trx);

            // if ($arr_m2->is_flexible == 1) {
            //     $sql_kurang_saldo = "update tbl_member_channel set today_trx = today_trx + $amount_add where alias = '$alias_add' and interface = 'NFC';"
            //         . "update tbl_member_account set saldo_sekolah = saldo_sekolah + $amount_minus,last_trx='$jlast_trx',last_amount='$amount_minus',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo_sekolah as saldo;";
            // } else {
                $sql_kurang_saldo = "update tbl_member_channel set today_trx = today_trx + $amount_add where alias = '$alias_add' and interface = 'NFC';"
                    . "update tbl_member_account set saldo = saldo + $amount_minus,last_trx='$jlast_trx',last_amount='$amount_minus',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo;";
            // }
            // $sql_kurang_saldo = "update tbl_member_channel set today_trx = today_trx + $amount_add where alias = '$alias_add' and interface = 'NFC';"
            //         . "update tbl_member_account set saldo = saldo + $amount_minus,last_trx='$jlast_trx',last_amount='$amount_minus',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo;";
            $saldo_noid = $db->singleRow($sql_kurang_saldo);
            $saldo_last = $saldo_noid->saldo;

            $data_trx_add = array(
                'username'         => $username,
                'interface'        => $interface,
                'product'          => 'CASH_OUT',
                'product_detail'   => 'SALDO',
                'idpel'            => $noid_add,
                'idpel_name'       => $nama_add,
                'amount'           => $amount_add,
                'limit'            => $new_limit,
                'keterangan'       => $keterangan_add,
                'reff'             => $ref,
                'trace_id'         => $ref,
                'lembar'           => 1,
                'response_code'    => '0000',
                'response_message' => 'sukses',
            );
            $jlast_trx_noid = json_encode($data_trx_add);

            // if ($arr_m2->is_flexible == 1) {
            //     $sql_tambah_saldo = "update tbl_member_account set saldo_sekolah = saldo_sekolah + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo_sekolah as saldo;";
            // } else {
                $sql_tambah_saldo = "update tbl_member_account set saldo = saldo + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo;";
            // }
            // $sql_tambah_saldo = "update tbl_member_account set saldo = saldo + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo;";
            $saldo_add      = $db->singleRow($sql_tambah_saldo);
            $saldo_add_last = $saldo_add->saldo;

            $response = array(
                'response_code'    => '0000',
                'saldo'            => $saldo_last,
                'struk'            => 'struk',
                'response_message' => "CASH OUT SALDO atas nama $nama_add Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL. REFF : $ref",
                'trace_id'         => $ref,
            );

            $msg_out = $konfig->namaAplikasi() . ", TRANSAKSI CASH OUT DI $nama_member oleh $nama_add Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL REFF $ref. Saldo Rp. " . $fungsi->rupiah($saldo_add_last);
            $db->kirimMessage($noid_add, $msg_out);
        } else {
            $error->tipeActionTidakValid($saldo_member);
        }
    } else {
        $error->accountTidakValid($saldo_member);
    }
} else {
    //kartu tidak terdaftar
}

$reply = json_encode($response);
