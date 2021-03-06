<?php

$action = $jreq->detail->action; //inq exec
$id_add = $jreq->detail->id;
$bukti_add = strtoupper($jreq->detail->bukti);

$sql_cek_konf = "select * from log_konfirmasi_topup where id = $id_add and status = 0;";
$arr_cek_konf = $db->singleRow($sql_cek_konf);

if (isset($arr_cek_konf->id)) {
    $noid_add = $arr_cek_konf->noid;
    $amount_add = $arr_cek_konf->nominal;
    $reff_add = $arr_cek_konf->reff;
    $tujuan_add = $arr_cek_konf->bank;
    $keterangan_add = $arr_cek_konf->keterangan;

    $arr_cek_mbr = $db->cekNoidMember($noid_add);

    if (!isset($arr_cek_mbr->id)) {
        $error->accountTidakAda($saldo_member);
    }
    $noid_add = $arr_cek_mbr->noid;
    $nama_add = $arr_cek_mbr->nama;
    $tipe_add = $arr_cek_mbr->tipe;
    $nohp_email_add = $arr_cek_mbr->nohp_email;

    if ($noid_add == $noid) {
        $error->accountTidakValid($saldo_member);
    }

    if ($amount_add < 1000) {
        $error->minimalTransaksi($saldo_member);
    }

    $aturan = $tipe_member . $tipe_add;

    if ($aturan == 'ADMINM1' || $aturan == 'ADMINFINANCE' || $aturan == 'FINANCEM1' || $aturan == 'FINANCEM2' || $aturan == 'FINANCEM3'
            | $aturan == 'ADMINM2' || $aturan == 'ADMINM3') {

        if ($action == 'inq') {
            $response = array(
                'response_code' => '0000',
                'saldo' => $saldo_member,
                'response_message' => "Apakah anda ingin melakukan Validasi TOPUP Tiket Deposit Saldo "
                . "ke $nama_add Rp. $amount_add via $tujuan_add ?"
            );
        } elseif ($action == 'exec') {

            if (($saldo_member < $amount_add) && $tipe_member != 'ADMIN') {
                $error->saldoTidakCukup($saldo_member);
            } else {
                $amount_minus = $amount_add * -1;
                $data_trx = array(
                    'username' => $username,
                    'interface' => $interface,
                    'product' => 'TIKET DEPOSIT',
                    'product_detail' => 'SALDO',
                    'idpel' => $noid_add,
                    'idpel_name' => $nama_add,
                    'amount' => $amount_add,
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

                $msg_out = $konfig->namaAplikasi() . ", TOPUP Tiket Deposit SALDO Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL REFF $ref. Saldo Rp. " . $fungsi->rupiah($saldo_add_last);
                $db->kirimMessage($noid_add, $msg_out);
            }
            $sql_update_konf = "update log_konfirmasi_topup set status=1, waktu_proses = now(), "
            . "noid_executor = '$noid', bukti_transfer = '$bukti_add' where id = $id_add;";
            $db->singleRow($sql_update_konf);
        } else {
            $error->tipeActionTidakValid($saldo_member);
        }
    } else {
        $error->accountTidakValid($saldo_member);
    }

    
} else {
    $response = array(
        'response_code' => '0403',
        'response_message' => "TOPUP GAGAL, Data Konfirmasi Deposit tidak ditemukan",
        'saldo' => $saldo_member
    );
}

$reply = json_encode($response);
