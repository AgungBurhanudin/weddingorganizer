<?php

require_once '../app/vendor/Excel/reader.php';

if (isset($_FILES['files']) && $_FILES['files']['size'] > 0) {
    $result = true;
    $data   = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('CP1251');
    $typeFile = $_FILES['files']['type'];
    $data->read($_FILES['files']['tmp_name']);

    $arr_mbr = $db->cekNoidMember($noid);
    
    if (!isset($arr_mbr->id)) {
        $error->accountTidakAda($saldo_member);
    }
    $noid_member       = $arr_mbr->noid;
    $nama_member       = $arr_mbr->nama;
    $tipe_member       = $arr_mbr->tipe;
    $nohp_email_member = $arr_mbr->nohp_email;
    $hak_saldo_member  = $arr_mbr->hak_saldo;

    $listSiswa   = array();
    $message     = array();
    $validFormat = false;
    for ($i = 1; $i <= count($data->sheets[0]['cells']); $i++) {
        if (trim($data->sheets[0]['cells'][$i][1]) == "") {
            // nothing to do
        } else if (strtoupper(trim($data->sheets[0]['cells'][$i][1])) == "NO") {
            if (strtoupper(trim($data->sheets[0]['cells'][$i][1])) == "NO"
                && strtoupper(trim($data->sheets[0]['cells'][$i][2])) == "NO VA"
                && strtoupper(trim($data->sheets[0]['cells'][$i][3])) == "NOMINAL"
                && strtoupper(trim($data->sheets[0]['cells'][$i][4])) == "KETERANGAN") {
                $validFormat = true;
            } else {
                $msg .= "";
                break;

            }
        } else if ($validFormat == true) {
            $validData = true;
            if (!isset($data->sheets[0]['cells'][$i][2])) {
                $validData = false;
            } else {
                $no_va = trim($data->sheets[0]['cells'][$i][2]);
            }

            if (!isset($data->sheets[0]['cells'][$i][3])) {
                $validData = false;
            } else {
                $amount_add = trim($data->sheets[0]['cells'][$i][3]);
            }

            if (!isset($data->sheets[0]['cells'][$i][4])) {
                $keterangan_add = "";
            } else {
                $keterangan_add = trim($data->sheets[0]['cells'][$i][4]);
            }

            $tujuan_add = "ON US";

            $query_cek_member = "SELECT * FROM tbl_member_channel WHERE va_1 = '$no_va' OR va_2 = '$no_va' OR va_3 = '$no_va' OR va_4 = '$no_va'";
             // echo "$query_cek_member";
            $arr_cek_member = $db->singleRow($query_cek_member);
            // print_r($arr_cek_member);
            $noid_add       = $arr_cek_member->noid;

            $arr_cek_mbr = $db->cekNoidMember($noid_add);
            if (!isset($arr_cek_mbr->id)) {
                $error->accountTidakAda($saldo_member);
            }
            $noid_add       = $arr_cek_mbr->noid;
            $nama_add       = $arr_cek_mbr->nama;
            $tipe_add       = $arr_cek_mbr->tipe;
            $nohp_email_add = $arr_cek_mbr->nohp_email;
            $hak_saldo_add  = $arr_cek_mbr->hak_saldo;

            $amount_minus = $amount_add * -1;
            $data_trx     = array(
                'username'         => $username,
                'interface'        => $interface,
                'product'          => 'TOPUP',
                'product_detail'   => 'SALDO',
                'idpel'            => $noid_member,
                'idpel_name'       => $nama_member,
                'amount'           => $amount_minus,
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
                    . "values (now(),'$noid','$ref', $amount_minus,$saldo_last,'$jlast_trx');";
                $db->singleRow($sql_insert_manual);
            } else {
                $sql_kurang_saldo = "update tbl_member_account set saldo = saldo + $amount_minus,last_trx='$jlast_trx',last_amount= '$amount_minus',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_member' returning saldo;";

                $saldo_noid = $db->singleRow($sql_kurang_saldo);
                $saldo_last = $saldo_noid->saldo;
            }
            $data_trx_add = array(
                'username'         => $nama_add,
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
            $jlast_trx_noid   = json_encode($data_trx_add);
            $sql_tambah_saldo = "update tbl_member_account set saldo = saldo + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo;";
            $saldo_add        = $db->singleRow($sql_tambah_saldo);
            $saldo_add_last   = $saldo_add->saldo;

            //insert manual
            $sql_insert_manual = "insert into log_data_trx (waktu,noid,reff,amount,saldo,detail) "
                . "values (now(),'$noid_add','$ref',$amount_add,$saldo_add_last,'$jlast_trx_noid');";
            $db->singleRow($sql_insert_manual);

            // $response = array(
            //     'response_code'    => '0000',
            //     'saldo'            => $saldo_add_last,
            //     'response_message' => "TOPUP SALDO Sekolah KE $noid_add a.n $nama_add Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL. REFF : $ref",
            //     'trace_id'         => $ref,
            // );

            $msg_out = $konfig->namaAplikasi() . ", TOPUP SALDO Sekolah DARI $nama_member Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL REFF $ref. Saldo Rp. " . $fungsi->rupiah($saldo_add_last);
            $db->kirimMessage($noid_add, $msg_out);

            $message[] = array(
                'saldo'    => $saldo_add_last,
                'message'  => $msg_out,
                'trace_id' => $ref,
            );
        }
    }
    $response = array(
        'response_code'    => '0000',
        'response_message' => $message,
    );

} else {
    $response = array(
        'response_code'    => '0099',
        'response_message' => 'Tidak ada file yang di upload atau File yang diupload kosong',
    );
}

$reply = json_encode($response);
