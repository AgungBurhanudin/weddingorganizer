<?php
$dbSekolah = new Models\DbSekolah();
$action = $jreq->detail->action; //inq exec
$interface_add = 'NFC';
$alias_add = strtoupper($jreq->detail->alias);
$passw_add = strtoupper($jreq->detail->passw);
$amount_add = $jreq->detail->nominal;
$keterangan_add = strtoupper($jreq->detail->keterangan);

$sql_cek_kartu = "select id,noid,nama,limit_trx - today_trx as limit_trx,passw,appid from "
        . "tbl_member_channel where alias = '$alias_add' and interface = '$interface_add';";
$arr_cek_kartu = $db->singleRow($sql_cek_kartu);

if (isset($arr_cek_kartu->id)) {
    $noid_add = $arr_cek_kartu->noid;
    $limit_trx = $arr_cek_kartu->limit_trx;
    $passw = $arr_cek_kartu->passw;
    $nama = $arr_cek_kartu->nama;

    if ($limit_trx <= $amount_add) {
        $response = array(
            'response_code' => '0404',
            'response_message' => 'GAGAL, LIMIT TRANSAKSI HARIAN TIDAK MENCUKUPI. SISA LIMIT RP. ' . $fungsi->rupiah($limit_trx),
            'nama' => $nama,
            'saldo' => $saldo_member,
        );
        die(json_encode($response));
    }

    $arr_cek_mbr = $db->cekNoidMember($noid_add);
    if (!isset($arr_cek_mbr->id)) {
        $error->accountTidakAda($saldo_member);
    }
    $arr_member = $db->cekId('tbl_member_account', 'noid', $noid_add);
    $noid_act = $arr_member->noid_act;
    //echo "SELECT * FROM tbl_member_account WHERE noid = '$noid_add' AND tipe = 'M2'";
    $arr_m2 = $db->singleRow("SELECT * FROM tbl_member_account WHERE noid = '$noid_act' AND tipe = 'M2'");

    $noid_add = $arr_cek_mbr->noid;
    $nama_add = $arr_cek_kartu->nama;
    $tipe_add = $arr_cek_mbr->tipe;
    $saldo_add = $arr_cek_mbr->saldo;
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
                'response_code' => '0001',
                'saldo' => $saldo_member,
                'response_message' => "$nama_add, Masukkan PIN untuk Transaksi Rp. " . $fungsi->rupiah($amount_add) . " di $nama_member !",
            );
            die(json_encode($response));
        } elseif ($passw_add == $passw) {
            //lanjut
        } else {
            $response = array(
                'response_code' => '0001',
                'saldo' => $saldo_member,
                'nama' => $nama,
                'response_message' => "Transaksi GAGAL, PIN SALAH !",
            );
            die(json_encode($response));
        }
    }
//LANJUUUT
    $aturan = $tipe_member . $tipe_add;
    if ($aturan == 'M2M3' || $aturan == 'M3M3') {
        if ($action == 'inq') {
            $response = array(
                'response_code' => '0000',
                'nama' => $nama,
                'saldo' => $saldo_member,
                'response_message' => "Apakah anda ingin melakukan Cash Out atas nama $nama_add Rp. " . $fungsi->rupiah($amount_add) . " ?",
            );
            die(json_encode($response));
        } elseif ($action == 'exec') {
            if ($saldo_add < $amount_add) {
                $error->saldoTargetTidakCukup($saldo_member);
            }
            $new_limit = $limit_trx - $amount_add;
            $amount_minus = $amount_add * -1;
            $data_trx = array(
                'username' => $nama_member,
                'interface' => $interface,
                'product' => 'CASH_OUT',
                'product_detail' => 'SALDO',
                'idpel' => $noid,
                'idpel_name' => $nama_member,
                'amount' => $amount_minus,
                'limit' => $new_limit,
                'keterangan' => $keterangan_add,
                'reff' => $ref,
                'trace_id' => $ref,
                'lembar' => 1,
                'response_code' => '0000',
                'response_message' => 'sukses',
            );
            $jlast_trx = json_encode($data_trx);

            // if ($arr_m2->is_flexible == 1) {
            //     $sql_kurang_saldo = "update tbl_member_channel set today_trx = today_trx + $amount_add where alias = '$alias_add' and interface = 'NFC';"
            //         . "update tbl_member_account set saldo_sekolah = saldo_sekolah + $amount_minus,last_trx='$jlast_trx',last_amount='$amount_minus',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo_sekolah AS saldo;";
            // } else {
            $sql_kurang_saldo = "update tbl_member_channel set today_trx = today_trx + $amount_add where alias = '$alias_add' and interface = 'NFC';"
                    . "update tbl_member_account set saldo = saldo + $amount_minus,last_trx='$jlast_trx',last_amount='$amount_minus',last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid_add' returning saldo;";
            // }
            $saldo_noid = $db->singleRow($sql_kurang_saldo);
            $saldo_last = $saldo_noid->saldo;

            $data_trx_add = array(
                'username' => $username,
                'interface' => $interface,
                'product' => 'CASH_OUT',
                'product_detail' => 'SALDO',
                'idpel' => $noid_add,
                'idpel_name' => $nama_add,
                'amount' => $amount_add,
                'limit' => $new_limit,
                'keterangan' => $keterangan_add,
                'reff' => $ref,
                'trace_id' => $ref,
                'lembar' => 1,
                'response_code' => '0000',
                'response_message' => 'sukses',
            );
            $jlast_trx_noid = json_encode($data_trx_add);

            // if ($arr_m2->is_flexible == 1) {
            //     $sql_tambah_saldo = "update tbl_member_account set saldo_sekolah = saldo_sekolah + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo_sekolah AS saldo;";
            // } else {
            $sql_tambah_saldo = "update tbl_member_account set saldo = saldo + $amount_add,last_trx='$jlast_trx_noid',last_amount=$amount_add,last_reff='$ref',last_fee='{}',last_lembar=1 where noid = '$noid' returning saldo;";
            // }
            $saldo_add = $db->singleRow($sql_tambah_saldo);
            $saldo_add_last = $saldo_add->saldo;

            if ($saldo_last > 100000) {
                $msg_saldo = "Sisa Saldo Lebih dari 100.000 ";
            } else {
                $msg_saldo = (int) $saldo_last;
            }

            //Tambahan Insert Ke Jurnal

            $result = true;
            $tanggal = date('Y-m-d');
            $waktu = date('H:i:s');
            $insert = $db->singleRow("INSERT INTO tbl_jurnal (transaksi, tanggal, waktu, keterangan, kode) "
                    . "VALUES ('CASH OUT' , '$tanggal', '$waktu', '$keterangan_add', '$ref') RETURNING id;");
            if (isset($insert->id)) {
                $result = $result && true;
                $id_jurnal = $insert->id;
                //Add Saldo Ke User
                $nfc_id = $alias_add;
                $arr_siswa = $db->singleRow("SELECT b.*,a.kode_sekolah FROM tbl_member_channel a LEFT JOIN tbl_member_account b ON "
                        . "a.noid = b.noid WHERE a.alias = '$nfc_id' AND a.interface = 'NFC'");
                
                $noid_ortu = $arr_siswa->noid;
                $noid_canten = $jreq->noid; 

                $noid_m2 = substr($noid_ortu,0,7) . "000000000";
                
                $arr_sekolah = $db->cekId('tbl_act_card','noid',$noid_m2);
                $kode_sekolah = $arr_sekolah->alias_act;
                
                $arr_sekolah2 = $dbSekolah->cekId('tbl_sekolah','kode_sekolah', $kode_sekolah);
                $id_sekolah = $arr_sekolah2->id;
                $update_id = $db->singleRow("UPDATE tbl_jurnal SET kode_sekolah = '$id_sekolah' where id = $id_jurnal;");

                $arr_member_account_ortu = $db->cekId('tbl_member_account', 'noid', $noid_ortu);
                $arr_member_account_cntn = $db->cekId('tbl_member_account', 'noid', $noid_canten);
                if (empty($arr_member_account_ortu) || empty($arr_member_account_cntn)) {
                    $db->deleteJurnal($id_jurnal);
                    die(json_encode(
                                    array(
                                        'response_code' => '0099',
                                        'response_message' => 'Cash Out Gagal',
                                    )
                            )
                    );
                } else {
                    
                    //Potong Saldo 
                    //Debit ke Akun Canteen
                    $result = $result && $db->doInsertDetailJurnal($id_jurnal, $noid_canten, $arr_member_account_cntn->nama, 'D', $amount_add);
                    //Kredit Ke Akun Orang Tua
                    $result = $result && $db->doInsertDetailJurnal($id_jurnal, $noid_ortu, $arr_member_account_ortu->nama, 'K', $amount_add);

                }
            }
            $response = array(
                'response_code' => '0000',
                'nama' => $nama,
                'saldo' => $msg_saldo, //$saldo_add_last,
                'struk' => 'struk',
                'response_message' => "CASH OUT SALDO atas nama $nama_add Rp. " . $fungsi->rupiah($amount_add) . " BERHASIL. REFF : $ref",
                'trace_id' => $ref,
                'sisa_limit' => $new_limit,
                'saldo_kantin' => (int) $saldo_add_last
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
        'response_code' => '0501',
        'response_message' => 'KARTU NFC ' . $alias_add . ' TIDAK TERDAFTAR',
        'saldo' => $saldo_member);
}

$reply = json_encode($response);
