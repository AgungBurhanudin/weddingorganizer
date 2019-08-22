<?php

$action = $jreq->detail->action; //inq exec
$nohp_email_add = strtoupper($jreq->detail->nohp_email);
$amount_add = $jreq->detail->nominal;
$keterangan_add = strtoupper($jreq->detail->keterangan);
$tujuan_add = 'ON US';

$arr_cek_mbr = $db->cekNohpMember($nohp_email_add);

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
//ADMIN HANYA BOLEH KE M1 DAN FINANCE AJA
//M1 HANYA BISA KE M2 DAN M3    
//M2 HANYA BOLEH KE M3
//FINANCE HANYA BOLEH KE M1

if ($aturan == 'ADMINM1' || $aturan == 'ADMINM2' || $aturan == 'ADMINM3' || $aturan == 'ADMINFINANCE' || $aturan == 'FINANCEM1' || $aturan == 'FINANCEM2' || $aturan == 'FINANCEM3' || $aturan == 'M1M2' || $aturan == 'M1M3' || $aturan == 'M2M2' || $aturan == 'M2M3' || $aturan == 'M3M3') {

    if ($action == 'inq') {
        $response = array(
            'response_code' => '0000',
            'saldo' => $saldo_member,
            'response_message' => "Apakah anda ingin melakukan TRANSFER Saldo ke $nama_add Rp. " . $fungsi->rupiah($amount_add) . " ?"
        );
    } elseif ($action == 'exec') {

        if ($saldo_member < $amount_add) {
            $error->saldoTidakCukup($saldo_member);
        } else {
            $amount_minus = $amount_add * -1;
            $data_trx = array(
                'username' => $username,
                'interface' => $interface,
                'product' => 'TRANSFER',
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

            $sql_kurang_saldo = "update tbl_member_account set saldo = saldo + $amount_minus,last_trx='$jlast_trx',last_amount='$amount_minus',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo;";
            $saldo_noid = $db->singleRow($sql_kurang_saldo);
            $saldo_last = $saldo_noid->saldo;

            $data_trx_add = array(
                'username' => $nama_member,
                'interface' => $interface,
                'product' => 'TRANSFER',
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
                'response_message' => "TRANSFER SALDO KE $noid_add a.n $nama_add Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL. REFF : $ref",
                'trace_id' => $ref
            );

            $msg_out = $konfig->namaAplikasi() . ", TRANSFER SALDO DARI $nama_member Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL REFF $ref. Saldo Rp. " . $fungsi->rupiah($saldo_add_last);
            $db->kirimMessage($noid_add, $msg_out);
        }
    } else {
        $error->tipeActionTidakValid($saldo_member);
    }
} else {
    $error->accountTidakValid($saldo_member);
}
$reply = json_encode($response);
