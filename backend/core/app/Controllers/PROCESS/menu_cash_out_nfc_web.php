<?php

$action         = $jreq->detail->action; //inq exec request
$amount_add     = $jreq->detail->nominal;
$keterangan_add = strtoupper($jreq->detail->keterangan);

if ($action == 'request') {
    $sql_insert = "delete from log_emoney where noid = '$noid' and username = '$username';"
        . "insert into log_emoney (waktu,noid,username,amount,reff,keterangan,stat) values "
        . "(now(),'$noid','$username',$amount_add,'$ref','$keterangan_add',1) returning id;";
    $arr_insert    = $db->singleRow($sql_insert);
    $id_log_emoney = $arr_insert->id;
    //menunggu kartu ditempel
    for ($wait = 0; $wait <= 60; $wait++) {
        $sql_wait     = "select * from log_emoney where id = $id_log_emoney";
        $arr_cek_wait = $db->singleRow($sql_wait);

        if ($arr_cek_wait->stat == 2) {
            $alias_add = $arr_cek_wait->target_alias;
            $action    = 'inq';
            $wait      = 60;
            //delete data waiting
            $db->singleRow("delete from log_emoney where id = $id_log_emoney");
        }
        sleep(1);
    }
    if ($action == 'request') {
        //gagal, tidak ada kartu
        $response = array(
            'response_code'    => '0404',
            'response_message' => 'GAGAL, Kartu NFC belum ditempelkan, silahkan mengulang transaksi .' . $wait,
            'saldo'            => $saldo_member,
        );
        die(json_encode($response));
    }
} else {
    $alias_add = strtoupper($jreq->detail->alias);
}

$interface_add = 'NFC';

$passw_add = strtoupper($jreq->detail->passw);

$sql_cek_kartu = "select id,noid,nama,limit_trx - today_trx as limit_trx,passw,appid,photo_identity from "
    . "tbl_member_channel where alias = '$alias_add' and interface = '$interface_add';";
$arr_cek_kartu = $db->singleRow($sql_cek_kartu);

if (isset($arr_cek_kartu->id)) {

    $noid_add  = $arr_cek_kartu->noid;
    $limit_trx = $arr_cek_kartu->limit_trx;
    $passw     = $arr_cek_kartu->passw;
    $photo     = $arr_cek_kartu->photo_identity;

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
    $arr_m2 = $db->cekId('tbl_member_account', 'noid_act', $noid_add);

    $noid_add       = $arr_cek_mbr->noid;
    $nama_add       = $arr_cek_kartu->nama;
    $tipe_add       = $arr_cek_mbr->tipe;
    $saldo_add      = $arr_cek_mbr->saldo;
    $nohp_email_add = $arr_cek_mbr->nohp_email;

    if ($noid_add == $noid) {
        $error->accountTidakValid($saldo_member);
    }
    if ($amount_add < 500) {
        $error->minimalTransaksi($saldo_member);
    }

//jika 0,7 noid dan noid_add sama, jika tidak butuh pin
    if (substr($noid_add, 0, 7) != substr($noid, 0, 7)) {
        //butuh pin
        if (strlen($passw_add) < 3) {
            $response = array(
                'response_code'    => '0001',
                'saldo'            => $saldo_member,
                'nfc_id'           => $alias_add,
                'photo'            => $photo,
                'response_message' => "$nama_add, Masukkan PIN untuk Transaksi Rp. " . $fungsi->rupiah($amount_add) . " di $nama_member !",
            );
            die(json_encode($response));
        } elseif ($passw_add == $passw) {
            //lanjut
        } else {
            $response = array(
                'response_code'    => '0001',
                'saldo'            => $saldo_member,
                'response_message' => "Transaksi GAGAL, PIN SALAH !",
            );
            die(json_encode($response));
        }
    }
//LANJUUUT
    $aturan = $tipe_member . $tipe_add;
    if ($tipe_member == 'ADMIN' || $aturan == 'M2M3' || $aturan == 'M3M3') {
        if ($action == 'inq') {
            $response = array(
                'response_code'    => '0000',
                'saldo'            => $saldo_member,
                'nfc_id'           => $alias_add,
                'photo'            => $photo,
                'response_message' => "Apakah anda ingin melakukan Cash Out atas nama $nama_add Rp. " . $fungsi->rupiah($amount_add) . " ?",
            );
            die(json_encode($response));
        } elseif ($action == 'exec') {
            if ($saldo_add < $amount_add) {
                $error->saldoTargetTidakCukup($saldo_member);
            }
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
            //     $sql_tambah_saldo = "update tbl_member_account set saldo_sekolah = saldo_sekolah + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo_sekolah AS saldo;";
            // } else {
                $sql_tambah_saldo = "update tbl_member_account set saldo = saldo + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo;";
            // }

            $saldo_add      = $db->singleRow($sql_tambah_saldo);
            $saldo_add_last = $saldo_add->saldo;

            $response = array(
                'response_code'    => '0000',
                'saldo'            => $saldo_add_last,
                'struk'            => 'struk',
                'response_message' => "CASH OUT SALDO atas nama $nama_add Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL. REFF : $ref",
                'trace_id'         => $ref,
            );

            $msg_out = $konfig->namaAplikasi() . ", TRANSAKSI CASH OUT DI $nama_member oleh $nama_add Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL REFF $ref. Saldo Rp. " . $fungsi->rupiah($saldo_last);
            $db->kirimMessage($noid_add, $msg_out);
        } else {
            $error->tipeActionTidakValid($saldo_member);
        }
    } else {
        $error->accountTidakValid($saldo_member);
    }
} else {
    //kartu tidak terdaftar
    $response = array(
        'response_code'    => '0501',
        'response_message' => 'KARTU NFC ' . $alias_add . ' TIDAK TERDAFTAR',
        'saldo'            => $saldo_member);
}

$reply = json_encode($response);
