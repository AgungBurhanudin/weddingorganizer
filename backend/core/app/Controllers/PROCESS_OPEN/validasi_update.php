<?php
$dbSekolah = new Models\DbSekolah();

//if mobile kirim password yang akan digunakan
$token_aktivasi   = strtoupper($jreq->token_aktivasi);
$arr_cek_validasi = $db->singleRow("SELECT id,noid_agen,tipe_agen FROM log_validasi WHERE noid = '$nohp_email' "
    . "and kode_validasi = '$token_aktivasi' and status = 9 and date(waktu) = date(now()) order by id desc limit 1");

$noid_add = "";
if ($arr_cek_validasi != false) {
    //Data Siswa
    $nama_siswa             = strtoupper(trim($jreq->detail->nama));
    $tgl_lahir_siswa        = isset($jreq->detail->tanggal_lahir) ? strtoupper(trim($jreq->detail->tanggal_lahir)) : "";
    $id_sekolah             = $jreq->detail->id_sekolah;
    $query_cek_siswa        = "SELECT a.* FROM tbl_siswa a 
                             LEFT JOIN tbl_sekolah b ON a.id_sekolah = b.id 
                             WHERE upper(nama) = '$nama_siswa' AND tanggal_lahir = '$tgl_lahir_siswa'
                             AND b.kode_sekolah = '$id_sekolah'";
                             //echo "$query_cek_siswa";
    $arr_siswa              = $dbSekolah->singleRow($query_cek_siswa);
    if(!isset($arr_siswa->nis)){        
        $response = array(
            'response_code'    => '9999',
            'response_message' => 'Data Siswa Terdaftar Di Sekolah Lain',
        );
        die(json_encode($response));
    }

    //Data Orang Tua
    $nama_add             = strtoupper(trim($jreq->detail->nama_ortu));
    $nik_add              = isset($jreq->detail->nik) ? strtoupper(trim($jreq->detail->nik)) : "";
    $tgl_lahir_add        = isset($jreq->detail->tgl_lahir) ? strtoupper(trim($jreq->detail->tgl_lahir)) : "";
    $alamat_add           = isset($jreq->detail->alamat) ? strtoupper(trim($jreq->detail->alamat)) : "";
    $provinsi             = isset($jreq->detail->provinsi) ? strtoupper($jreq->detail->provinsi) : "";
    $provinsi_value       = isset($jreq->detail->provinsi_value) ? strtoupper($jreq->detail->provinsi_value) : "";
    $kota_kabupaten       = isset($jreq->detail->kota_kabupaten) ? strtoupper($jreq->detail->kota_kabupaten) : "";
    $kota_kabupaten_value = isset($jreq->detail->kota_kabupaten_value) ? strtoupper($jreq->detail->kota_kabupaten_value) : "";
    $kecamatan            = isset($jreq->detail->kecamatan) ? strtoupper($jreq->detail->kecamatan) : "";
    $kecamatan_value      = isset($jreq->detail->kecamatan_value) ? strtoupper($jreq->detail->kecamatan_value) : "";
    $kelurahan            = isset($jreq->detail->kelurahan) ? strtoupper($jreq->detail->kelurahan) : "";
    $kelurahan_value      = isset($jreq->detail->kelurahan_value) ? strtoupper($jreq->detail->kelurahan_value) : "";
    $email                = isset($jreq->detail->email) ? $jreq->detail->email : "";
    

    $rt      = isset($jreq->detail->rt) ? strtoupper($jreq->detail->rt) : "";
    $rw      = isset($jreq->detail->rw) ? strtoupper($jreq->detail->rw) : "";
    $kodepos = isset($jreq->detail->kodepos) ? strtoupper($jreq->detail->kodepos) : "";

    $jenis       = 'MEMBER';
    $noid        = $arr_cek_validasi->noid_agen;
    if(empty($noid) ||  $noid == ""){        
        $arr_act_card = $db->cekId('tbl_act_card', 'alias_act', $id_sekolah);
        $noid         = $arr_act_card->noid;
    }
    $awal_noid   = substr($noid, 0, 7);
    $tipe_member = $arr_cek_validasi->tipe_agen;
    if ($tipe_member == 'M1') {
        $tipe = 'M2';
    } else {
        $tipe = 'M3';
    }
    $saldo_member = 0;
    $jenis_tbl    = 1;
    $prefix_ca    = '0';
    $prefix_subca = '0';
    $noid_ca      = '0';
    $noid_subca   = '0';

    $aturan = $tipe_member . $tipe; //ADMIN... ADMINMEMBER SALESMEMBER

    if ($interface == 'WEB') {
        $username_add = substr(str_replace(' ', '', $nama_add), 0, 6) . $fungsi->randomNumber(4);
        $pass_add     = $fungsi->randomString(6);
        $appid_add    = '';
    } elseif ($interface == 'MOBILE') {
        $username_add_web = substr(str_replace(' ', '', $nama_add), 0, 6) . $fungsi->randomNumber(4);
        $pass_add_web     = $fungsi->randomString(6);
        $username_add     = $nohp_email;
        $pass_add         = strtoupper(trim($jreq->detail->password)); //ada password untuk mobile
        $appid            = preg_replace("/[^a-zA-Z0-9]/", "", $jreq->detail->appid);
        $secClient        = substr(base64_encode($appid . $tipebrowser), 15, 50);
        $appid_add        = $secClient . '#' . $appid;
    } else {
        $error->kesalahanSistem($tipe_request);
    }

    if (is_numeric($nohp_email) !== true) {
        $tipe_message = 'EMAIL';
    } else {
        $tipe_message = 'SMS';
    }

//cek apakah terdaftar, jika belum insert, jika sudah update (web dan mobile beda)
    $nohp_email_ = $awal_noid . "#" . $nohp_email;
    $arr_cek     = $db->cekNohpMember($awal_noid . "#" . $nohp_email);

    if (!isset($arr_cek->id)) {
        if ($aturan == 'M1M2' || $aturan == 'M2M3') {
            if ($jenis == 'MEMBER') {

                if ($tipe == 'M2' && $aturan == 'M1M2') {
                    $prefix_ca    = substr($noid, 0, 3);
                    $sql_count    = "select max(substring(noid from 4 for 4)) as jml from tbl_member_account where tipe = '$tipe' and substring(noid from 1 for 3) = '$prefix_ca'";
                    $arr_count    = $db->singleRow($sql_count);
                    $max_id       = (int) $arr_count->jml;
                    $prefix_subca = $prefix_ca . str_pad($max_id + 1, 4, "0", STR_PAD_LEFT);
                    $noid_add     = $prefix_subca . '000000000';
                    $noid_ca      = $prefix_ca . '0000000000000';
                    $noid_subca   = $noid_add;
                } elseif ($tipe == 'M3' && $aturan == 'M2M3') {
                    $prefix_ca     = substr($noid, 0, 3);
                    $prefix_subca  = substr($noid, 0, 7);
                    $sql_count     = "select max(substring(noid from 8 for 9)) as jml from tbl_member_account where tipe = '$tipe' and substring(noid from 1 for 7) = '$prefix_subca'";
                    $arr_count     = $db->singleRow($sql_count);
                    $max_id        = (int) $arr_count->jml;
                    $prefix_member = str_pad($max_id + 1, 9, "0", STR_PAD_LEFT);
                    $noid_add      = $prefix_subca . $prefix_member;
                    $noid_ca       = $prefix_ca . '0000000000000';
                    $noid_subca    = $prefix_subca . '000000000';
                    $nohp_email_   = $prefix_subca . "#$nohp_email";
                } else {
                    $error->regAccountTidakBerhak($saldo_member);
                }
            } else {
                $error->regAccountJenisSalah($saldo_member);
            }
        } else {
            $error->regAccountTidakBerhak($saldo_member);
        }
        if ($interface == 'WEB') {
            $msg_out = "Registrasi $jenis " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
            . "Website " . $konfig->urlWebLogin() . " USERNAME=$username_add PASSWORD=$pass_add";
        } else {
            $msg_out = "Registrasi $jenis " . $konfig->namaAplikasi() . " berhasil. "
            . "MOBILE PIN=$pass_add. Website " . $konfig->urlWebLogin() . " USERNAME=$username_add_web PASSWORD=$pass_add_web";
            $sql_web = "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,appid,kode_sekolah) values"
                . "('WEB','$noid_add','$username_add_web',now(),now(),'$pass_add_web','$nama_add','$nohp_email','','$id_sekolah');";
            $db->singleRow($sql_web);
        }
        $sql = "BEGIN TRANSACTION;"
            . "insert into tbl_member_account (noid,nama,alamat,nohp_email,tipe,jenis,noid_act,noid_mit,noid_submit,status,reg_date,saldo,"
            . "provinsi,kota_kabupaten,kecamatan,kelurahan,rt,rw,kodepos,nik,provinsi_value,kota_kabupaten_value,kecamatan_value,kelurahan_value,email) values"
            . "('$noid_add','$nama_add','$alamat_add','$nohp_email_','$tipe',$jenis_tbl,'$noid','$noid_ca','$noid_subca',1,now(),0,"
            . "'$provinsi','$kota_kabupaten','$kecamatan','$kelurahan','$rt','$rw','$kodepos','$nik_add','$provinsi_value','$kota_kabupaten_value','$kecamatan_value','$kelurahan_value','$email');"
            . "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,appid,kode_sekolah) values"
            . "('$interface','$noid_add','$username_add',now(),now(),'$pass_add','$nama_add','$nohp_email','$appid_add','$id_sekolah');"
            . "insert into log_message(nohp_email,interface,msg,secret) values ('$nohp_email','$tipe_message','$msg_out',1);"
            . "COMMIT;";

//        die($sql);
        $db->singleRow($sql);
        $response = array(
            'response_code'    => '0000',
            'response_message' => "Sukses Registrasi, Periksa $tipe_message $nohp_email Anda.",
            'noid'             => $noid_add,
            'username'         => $username_add,
        );
    } else {
        $noid_add = $arr_cek->noid;
        $id_add   = $arr_cek->id;

        if ($interface == 'WEB') {
            //apakah sudah ada channel WEB nya
            $arr_chan = $db->cekNoidChannel($noid_add, 'WEB');
            if (isset($arr_chan->id)) {
                $sql_channel = "update tbl_member_channel set interface='$interface',noid='$noid_add',alias='$username_add',reg_date=now(),"
                    . "last_used=now(),passw='$pass_add',nama='$nama_add',email='$nohp_email',kode_sekolah='$id_sekolah' where id = $arr_chan->id;";
            } else {
                $sql_channel = "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,kode_sekolah) values"
                    . "('$interface','$noid_add','$username_add',now(),now(),'$pass_add','$nama_add','$nohp_email','$id_sekolah');";
            }

            $msg_out = "Registrasi ULANG $jenis " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
            . "Website " . $konfig->urlWebLogin() . " USERNAME=$username_add PASSWORD=$pass_add";
        } else {
            //apakah sudah ada channel MOBILE nya
            $arr_chan = $db->cekNoidChannel($noid_add, 'MOBILE');
            if (isset($arr_chan->id)) {
                $sql_channel = "update tbl_member_channel set interface='$interface',noid='$noid_add',alias='$username_add',reg_date=now(),"
                    . "last_used=now(),passw='$pass_add',nama='$nama_add',email='$nohp_email',appid='$appid_add',kode_sekolah='$id_sekolah' where id = $arr_chan->id;";
            } else {
                $sql_channel = "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,appid,kode_sekolah) values"
                    . "('$interface','$noid_add','$username_add',now(),now(),'$pass_add','$nama_add','$nohp_email','$appid_add','$id_sekolah');";
            }

            $msg_out = "Registrasi ULANG $jenis " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
                . "PASSWORD=$pass_add";
        }
        $sql = "BEGIN TRANSACTION;"
            . "update tbl_member_account set noid='$noid_add',nama='$nama_add',alamat='$alamat_add',"
            . "nohp_email='$nohp_email_',tipe='$tipe',jenis=$jenis_tbl,noid_act='$noid',noid_mit='$prefix_ca',"
            . "noid_submit='$prefix_subca',status=1,reg_date=now(),"
            . "provinsi='$provinsi',kota_kabupaten='$kota_kabupaten',kecamatan='$kecamatan',kelurahan='$kelurahan',"
            . "rt='$rt',rw='$rw',kodepos='$kodepos',nik='$nik_add',email='$email' where id=$id_add;"
            . "$sql_channel"
            . "insert into log_message(nohp_email,interface,msg,secret) values ('$nohp_email','$tipe_message','$msg_out',1);"
            . "COMMIT;";

//        die($sql);
        $db->singleRow($sql);
        $response = array(
            'response_code'    => '0000',
            'response_message' => "Sukses Registrasi ULANG, Periksa $tipe_message $nohp_email Anda.",
            'noid'             => $noid_add,
            'username'         => $username_add,
        );
    }

    if ((isset($noid_add) || !empty($noid_add) || $noid_add = "" || $noid_add != null) && ($id_sekolah != "" || isset($id_sekolah))) {
        //echo 1;
        $nama            = strtoupper($jreq->detail->nama);
        $tgl_lahir       = $jreq->detail->tanggal_lahir;
        $noid            = $noid_add;
        $query_cek_siswa = "SELECT * FROM tbl_siswa WHERE upper(nama) = '$nama' AND tanggal_lahir = '$tgl_lahir'";
        $arr_siswa       = $dbSekolah->singleRow($query_cek_siswa);
        $response_       = false;
        if (empty($arr_siswa) || !isset($arr_siswa->nis) || $arr_siswa == "") {
            //echo 2;
            $response_ = false;
        } else {
            //echo 3;
            $nis = $arr_siswa->nis;

            $query_ok = "SELECT * FROM tbl_member_channel WHERE kode_sekolah = '$id_sekolah' AND noid='$noid'";

            $arr_ok = $db->singleRow($query_ok);
            if (!empty($arr_ok)) {
                //echo 4;

                $query_cek_member_channel = "SELECT * FROM tbl_member_channel WHERE kode_sekolah = '$id_sekolah' AND nis = '$nis'";
                //echo $query_cek_member_channel;
                $arr_cek_member_channel = $db->singleRow($query_cek_member_channel);
                if (!empty($arr_cek_member_channel)) {
                    ///echo 5;
                    $arr_cek_member_account = $db->cekId('tbl_member_account', 'noid', $noid_add);
                    $interface              = "NFC";
                    $noid                   = $noid_add; //$arr_cek_member_channel->noid;
                    $alias                  = (empty($arr_siswa->nfc_id) || $arr_siswa->nfc_id == "") ? $arr_siswa->nis : $arr_siswa->nfc_id;
                    $passw                  = $arr_siswa->nis;
                    $status                 = "1";
                    $nama                   = $arr_siswa->nama;
                    $nis                    = $arr_siswa->nis;
                    $va1                    = $arr_siswa->nova1;
                    $va2                    = $arr_siswa->nova2;
                    $va3                    = $arr_siswa->nova3;
                    $va4                    = $arr_siswa->nova4;
                    $appid                  = $jreq->detail->appid;
                    $token                  = "";
                    $query                  = "UPDATE tbl_member_channel SET noid = '$noid' WHERE nis = '$nis' AND kode_sekolah = '$id_sekolah' RETURNING id;";
                    $insert                 = $db->singleRow($query);
                    $nama_wali              = ucwords($nama_add);
                    $nohp_wali              = ucwords($nohp_email);
                    $query_update           = "UPDATE tbl_siswa SET nama_wali = '$nama_wali', nohp_wali = '$nohp_wali', email_wali = '$email' WHERE nis = '$nis' RETURNING id";
                    //echo $query_update;
                    $update    = $dbSekolah->singleRow($query_update);
                    $response_ = false;
                } else {
                    //echo 6;
                    $arr_cek_member_account = $db->cekId('tbl_member_account', 'noid', $noid_add);
                    $interface              = "NFC";
                    $noid                   = $noid_add; //$arr_cek_member_channel->noid;
                    $alias                  = (empty($arr_siswa->nfc_id) || $arr_siswa->nfc_id == "") ? $arr_siswa->nis : $arr_siswa->nfc_id;
                    $passw                  = $arr_siswa->nis;
                    $status                 = "1";
                    $nama                   = $arr_siswa->nama;
                    $nis                    = $arr_siswa->nis;
                    $va1                    = $arr_siswa->nova1;
                    $va2                    = $arr_siswa->nova2;
                    $va3                    = $arr_siswa->nova3;
                    $va4                    = $arr_siswa->nova4;
                    $appid                  = $jreq->detail->appid;
                    $token                  = "";
                    $cek_alias              = $db->cekId('tbl_member_channel', 'nis', $nis);
                    $arr_sekolah            = $dbSekolah->cekId('tbl_sekolah','kode_sekolah', $id_sekolah);
                    $limit_trx              = 10000;
                    if(isset($arr_sekolah->limit_max)){
                        $limit_trx          = $arr_sekolah->limit_max;
                    }
                    if (empty($cek_alias)) {
                        $query = "INSERT INTO tbl_member_channel (interface, noid, alias, passw, appid, token, status, nama, email, kode_sekolah, nis, va_1, va_2, va_3, va_4, limit_trx) VALUES
('$interface','$noid','$alias','$passw','$appid','$token','$status','$nama','$email','$id_sekolah','$nis', '$va1', '$va2', '$va3', '$va4', '$limit_trx') RETURNING id;";

                        $insert = $db->singleRow($query);
                    } else {
                        $query  = "UPDATE tbl_member_channel SET noid = '$noid' WHERE nis = '$nis' AND kode_sekolah = '$id_sekolah' RETURNING id;";
                        
						$insert = $db->singleRow($query);
                    }

                    //$id_siswa     = $arr_siswa->id;
                    $nama_wali    = ucwords($nama_add);
                    $nohp_wali    = ucwords($nohp_email);
                    $query_update = "UPDATE tbl_siswa SET nama_wali = '$nama_wali', nohp_wali = '$nohp_wali', email_wali = '$email' WHERE nis = '$nis' RETURNING id";
                    
                    $update = $dbSekolah->singleRow($query_update);

                    if (isset($insert->id) && isset($update->id)) {
                        $json_siswa = json_encode($arr_siswa);
                        $response_  = true;
                    } else {
                        $response_ = false;
                    }
                }
            }
        }
    }
} else {
    $response = array(
        'response_code'    => '0091',
        'response_message' => 'KODE VALIDASI yang anda masukkan salah atau sudah berbeda tanggal',
    );
}
$reply = json_encode($response);
