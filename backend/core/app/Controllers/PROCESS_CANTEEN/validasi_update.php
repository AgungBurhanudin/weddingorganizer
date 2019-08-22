<?php

//if mobile kirim password yang akan digunakan
$token_aktivasi = strtoupper($jreq->token_aktivasi);
$arr_cek_validasi = $db->singleRow("SELECT id,noid_agen,tipe_agen FROM log_validasi WHERE noid = '$nohp_email' "
        . "and kode_validasi = '$token_aktivasi' and status = 9 and date(waktu) = date(now()) order by id desc limit 1");

if ($arr_cek_validasi != FALSE) {

    $nama_add 			  = strtoupper(trim($jreq->detail->nama));    
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

    $jenis = 'MEMBER';
    $noid = $arr_cek_validasi->noid_agen;
    $tipe_member = $arr_cek_validasi->tipe_agen;
    if ($tipe_member == 'M1') {
        $tipe = 'M2';
    } else {
        $tipe = 'M3';
    }
    $saldo_member = 0;
    $jenis_tbl = 1;
    $prefix_ca = '0';
    $prefix_subca = '0';
    $noid_ca = '0';
    $noid_subca = '0';

    $aturan = $tipe_member . $tipe; //ADMIN... ADMINMEMBER SALESMEMBER

    if ($interface == 'WEB') {
        $username_add = substr(str_replace(' ', '', $nama_add), 0, 6) . $fungsi->randomNumber(4);
        $pass_add = $fungsi->randomString(6);
        $appid_add = '';
    } elseif ($interface == 'MOBILE') {
        $username_add_web = substr(str_replace(' ', '', $nama_add), 0, 6) . $fungsi->randomNumber(4);
        $pass_add_web = $fungsi->randomString(6);
        $username_add = $nohp_email;
        $pass_add = strtoupper(trim($jreq->detail->password)); //ada password untuk mobile
        $appid = preg_replace("/[^a-zA-Z0-9]/", "", $jreq->detail->appid);
        $secClient = substr(base64_encode($appid . $tipebrowser), 15, 50);
        $appid_add = $secClient.'#'.$appid;
    } else {
        $error->kesalahanSistem($tipe_request);
    }
    
    if (is_numeric($nohp_email) !== TRUE) {
        $tipe_message = 'EMAIL';
    } else {
        $tipe_message = 'SMS';
    }

//cek apakah terdaftar, jika belum insert, jika sudah update (web dan mobile beda)
    $arr_cek = $db->cekNohpMember($nohp_email);
    if (!isset($arr_cek->id)) {
        if ($aturan == 'M1M2' || $aturan == 'M2M3') {
            if ($jenis == 'MEMBER') {
                
                if ($tipe == 'M2' && $aturan == 'M1M2') {
                    $prefix_ca = substr($noid, 0, 3);
                    $sql_count = "select count(id) as jml from tbl_member_account where tipe = '$tipe' and substring(noid from 1 for 3) = '$prefix_ca'";
                    $arr_count =  $db->singleRow($sql_count);
                    $prefix_subca = $prefix_ca . str_pad($arr_count->jml + 1, 4, "0", STR_PAD_LEFT);
                    $noid_add = $prefix_subca . '000000000';
                    $noid_ca = $prefix_ca.'0000000000000';
                    $noid_subca = $noid_add;
                } elseif ($tipe == 'M3' && $aturan == 'M2M3') {
                    $prefix_ca = substr($noid, 0, 3);
                    $prefix_subca = substr($noid, 0, 7);
                    $sql_count = "select count(id) as jml from tbl_member_account where tipe = '$tipe' and substring(noid from 1 for 7) = '$prefix_subca'";
                    $arr_count =  $db->singleRow($sql_count);
                    $prefix_member = str_pad($arr_count->jml + 1, 9, "0", STR_PAD_LEFT);
                    $noid_add = $prefix_subca . $prefix_member;
                    $noid_ca = $prefix_ca.'0000000000000';
                    $noid_subca = $prefix_subca.'000000000';
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
            $sql_web = "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,appid) values"
                . "('WEB','$noid_add','$username_add_web',now(),now(),'$pass_add_web','$nama_add','$nohp_email','');";
            // $db->singleRow($sql_web);
        }
        $sql = "BEGIN TRANSACTION;"
                . "insert into tbl_member_account (noid,nama,alamat,nohp_email,tipe,jenis,noid_act,noid_mit,noid_submit,status,reg_date,saldo,"
                . "provinsi,kota_kabupaten,kecamatan,kelurahan,rt,rw,kodepos,nik,provinsi_value,kota_kabupaten_value,kecamatan_value,kelurahan_value,email) values"
                . "('$noid_add','$nama_add','$alamat_add','$nohp_email','$tipe',$jenis_tbl,'$noid','$noid_ca','$noid_subca',1,now(),0,"
                . "'$provinsi','$kota_kabupaten','$kecamatan','$kelurahan','$rt','$rw','$kodepos','$nik_add','$provinsi_value','$kota_kabupaten_value','$kecamatan_value','$kelurahan_value','$email');"
                . "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,appid, grup) values"
                . "('$interface','$noid_add','$username_add',now(),now(),'$pass_add','$nama_add','$nohp_email','$appid_add',3);"
                . "insert into log_message(nohp_email,interface,msg,secret) values ('$nohp_email','$tipe_message','$msg_out',1);"
                . "COMMIT;";

//        die($sql);
        $db->singleRow($sql);
        $response = array(
            'response_code' => '0000',
            'response_message' => "Sukses Registrasi"//, Periksa $tipe_message $nohp_email Anda."
        );
    } else {
        $noid_add = $arr_cek->noid;
        $id_add = $arr_cek->id;

        if ($interface == 'WEB') {
            //apakah sudah ada channel WEB nya
            $arr_chan = $db->cekNoidChannel($noid_add, 'WEB');
            if (isset($arr_chan->id)) {
                $sql_channel = "update tbl_member_channel set interface='$interface',noid='$noid_add',alias='$username_add',reg_date=now(),"
                        . "last_used=now(),passw='$pass_add',nama='$nama_add',email='$nohp_email' where id = $arr_chan->id;";
            } else {
                $sql_channel = "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,grup) values"
                        . "('$interface','$noid_add','$username_add',now(),now(),'$pass_add','$nama_add','$nohp_email',3);";
            }

            $msg_out = "Registrasi ULANG $jenis " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
                    . "Website " . $konfig->urlWebLogin() . " USERNAME=$username_add PASSWORD=$pass_add";
        } else {
            //apakah sudah ada channel MOBILE nya
            $arr_chan = $db->cekNoidChannel($noid_add, 'MOBILE');
            if (isset($arr_chan->id)) {
                $sql_channel = "update tbl_member_channel set interface='$interface',noid='$noid_add',alias='$username_add',reg_date=now(),"
                        . "last_used=now(),passw='$pass_add',nama='$nama_add',email='$nohp_email',appid='$appid_add' where id = $arr_chan->id;";
            } else {
                $sql_channel = "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,appid,grup) values"
                        . "('$interface','$noid_add','$username_add',now(),now(),'$pass_add','$nama_add','$nohp_email','$appid_add',3);";
            }

            $msg_out = "Registrasi ULANG $jenis " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
                    . "PASSWORD=$pass_add";
        }
        $sql = "BEGIN TRANSACTION;"
                . "update tbl_member_account set noid='$noid_add',nama='$nama_add',alamat='$alamat_add',"
                . "nohp_email='$nohp_email',tipe='$tipe',jenis=$jenis_tbl,noid_act='$noid',noid_mit='$prefix_ca',"
                . "noid_submit='$prefix_subca',status=1,reg_date=now(),"
                . "provinsi='$provinsi',kota_kabupaten='$kota_kabupaten',kecamatan='$kecamatan',kelurahan='$kelurahan',"
                . "rt='$rt',rw='$rw',kodepos='$kodepos',nik='$nik_add',email='$email' where id=$id_add;"
                . "$sql_channel"
                . "insert into log_message(nohp_email,interface,msg,secret) values ('$nohp_email','$tipe_message','$msg_out',1);"
                . "COMMIT;";

//        die($sql);
        $db->singleRow($sql);
        $response = array(
            'response_code' => '0000',
            'response_message' => "Sukses Registrasi ULANG"//, Periksa $tipe_message $nohp_email Anda."
        );
    }
} else {
    $response = array(
        'response_code' => '0091',
        'response_message' => 'KODE VALIDASI yang anda masukkan salah atau sudah berbeda tanggal'
    );
}
$reply = json_encode($response);

