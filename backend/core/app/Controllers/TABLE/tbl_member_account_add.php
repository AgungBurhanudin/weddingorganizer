<?php

/*
{
"tipe_file": "TABLE",
"tipe_request": "tbl_member_account_add",
"detail": {
"jenis": "PEGAWAI/MEMBER",
"tipe": "ADMIN, FINANCE, CS, SALES, REPORTER, M1, M2, M3",
"nama": "",
"alamat": "salatiga",
"nohp_email": "BISA NOHP / EMAIL / NOMOR TAGIHAN"
},
"appid": "LKFCCF6O",
"token": "CCSGUTKSBAHP"
}:
 */
$dbSekolah            = new Models\DbSekolah();
$nama_add             = strtoupper(trim($jreq->detail->nama));
$nik_add              = strtoupper(trim($jreq->detail->nik));
$tgl_lahir_add        = strtoupper(trim($jreq->detail->tgl_lahir));
$alamat_add           = strtoupper(trim($jreq->detail->alamat));
$provinsi             = strtoupper($jreq->detail->provinsi);
$provinsi_value       = strtoupper($jreq->detail->provinsi_value);
$kota_kabupaten       = strtoupper($jreq->detail->kota_kabupaten);
$kota_kabupaten_value = strtoupper($jreq->detail->kota_kabupaten_value);
$kecamatan            = strtoupper($jreq->detail->kecamatan);
$kecamatan_value      = strtoupper($jreq->detail->kecamatan_value);
$kelurahan            = strtoupper($jreq->detail->kelurahan);
$kelurahan_value      = strtoupper($jreq->detail->kelurahan_value);
$rt                   = strtoupper($jreq->detail->rt);
$rw                   = strtoupper($jreq->detail->rw);
$kodepos              = strtoupper($jreq->detail->kodepos);
$nohp_email_add       = strtoupper($jreq->detail->nohp_email);
$jenis                = strtoupper($jreq->detail->jenis);
$tipe                 = strtoupper($jreq->detail->tipe);
$group                = isset($jreq->detail->group) ? strtoupper($jreq->detail->group) : "0";
$limit_max            = isset($jreq->detail->limit_max) ? strtoupper($jreq->detail->limit_max) : "10000";
$kode_sekolah         = "";//isset($jreq->detail->sekolah) ? $jreq->detail->sekolah : "";

$prefix_ca    = '0';
$prefix_subca = '0';
$noid_ca      = '0';
$noid_subca   = '0';
$hak_saldo    = 1;

$aturan = $tipe_member . $tipe; //ADMIN... ADMINMEMBER SALESMEMBER
if ($tipe_member == 'ADMIN' || $aturan == 'SALESM1' || $aturan == 'M1M2' || $aturan == 'M2M3') {
    if ($jenis == 'PEGAWAI') {
        $jenis_tbl = 2;
        switch ($tipe) {
            case "ADMIN":
                $prefix_tipe = '000000000001';
                break;
            case "FINANCE":
                $prefix_tipe = '000000000002';
                break;
            case "CS":
                $prefix_tipe = '000000000003';
                break;
            case "SALES":
                $prefix_tipe = '000000000004';
                break;
            case "REPORTER":
                $prefix_tipe = '000000000005';
                break;
        }

        $sql_count = "select count(id) as jml from tbl_member_account where tipe = '$tipe'";
        $arr_count = $db->singleRow($sql_count);
        $ittr      = str_pad($arr_count->jml + 1, 4, "0", STR_PAD_LEFT);
        $noid_add  = $prefix_tipe . $ittr;

        if (is_numeric($nohp_email_add) !== true) {
            $tipe_message = 'EMAIL';
        } else {
            $error->regAccountHarusEmail($saldo_member);
        }
    } elseif ($jenis == 'MEMBER') {
        $jenis_tbl = 1;
        //setting noid
        if ($jreq->detail->tipe == 'M1' && ($aturan == 'SALESM1' || $aturan == 'ADMINM1')) {
            $sql_count  = "select count(id) as jml from tbl_member_account where tipe = '$tipe'";
            $arr_count  = $db->singleRow($sql_count);
            $prefix_ca  = str_pad($arr_count->jml + 1, 3, "0", STR_PAD_LEFT);
            $noid_add   = $prefix_ca . '0000' . '000000000';
            $noid_ca    = $noid_add;
            $noid_subca = $noid_add;
            $hak_saldo  = isset($jreq->detail->korwil) ? (int) $jreq->detail->korwil : 1;
        } elseif ($jreq->detail->tipe == 'M2' && $aturan == 'M1M2') {
            $prefix_ca    = substr($noid, 0, 3);
            $sql_count    = "select max(substring(noid from 4 for 4)) as jml from tbl_member_account where tipe = '$tipe' and substring(noid from 1 for 3) = '$prefix_ca'";
            $arr_count    = $db->singleRow($sql_count);
            $max_id       = (int) $arr_count->jml;
            $prefix_subca = $prefix_ca . str_pad($max_id + 1, 4, "0", STR_PAD_LEFT);
            $noid_add     = $prefix_subca . '000000000';
            $noid_ca      = $prefix_ca . '0000000000000';
            $noid_subca   = $noid_add;
            $hak_saldo    = isset($jreq->detail->korwil) ? (int) $jreq->detail->korwil : 1;
        } elseif ($jreq->detail->tipe == 'M3' && $aturan == 'M2M3') {
            $prefix_ca     = substr($noid, 0, 3);
            $prefix_subca  = substr($noid, 0, 7);
            $sql_count     = "select max(substring(noid from 8 for 9)) as jml from tbl_member_account where tipe = '$tipe' and substring(noid from 1 for 7) = '$prefix_subca'";
            $arr_count     = $db->singleRow($sql_count);
            $max_id        = (int) $arr_count->jml;
            $prefix_member = str_pad($max_id + 1, 9, "0", STR_PAD_LEFT);
            $noid_add      = $prefix_subca . $prefix_member;
            $noid_ca       = $prefix_ca . '0000000000000';
            $noid_subca    = $prefix_subca . '000000000';
        } else {
            $error->regAccountTidakBerhak($saldo_member);
        }
        if (is_numeric($nohp_email_add) !== true) {
            $tipe_message = 'EMAIL';
        } else {
            $tipe_message = 'SMS';
        }
    } else {
        $error->regAccountJenisSalah($saldo_member);
    }
} else {
    $error->regAccountTidakBerhak($saldo_member);
}

$username_add = substr(str_replace(' ', '', $nama_add), 0, 6) . $fungsi->randomNumber(4);
$pass_add     = $fungsi->randomString(6);

$arr_cek = $db->cekNohpMember($nohp_email_add);

if (!isset($arr_cek->id)) {
    if ($tipe == 'M2') {
        $noid_add_m2 = $noid_add;
        //create noid padanan admin dan topup
        $prefix_ca     = substr($noid_add_m2, 0, 3);
        $prefix_subca  = substr($noid_add_m2, 0, 7);
        
        $arr_count     = $db->singleRow($sql_count);
        $prefix_admin  = str_pad(1, 9, "0", STR_PAD_LEFT);
        $noid_admin    = $prefix_subca . $prefix_admin;

        $prefix_topup  = str_pad(2, 9, "0", STR_PAD_LEFT);
        $noid_topup    = $prefix_subca . $prefix_topup;  

        $prefix_pembayaran  = str_pad(3, 9, "0", STR_PAD_LEFT);
        $noid_pembayaran    = $prefix_subca . $prefix_pembayaran;        

        //end
        $nama_aktivasi = $fungsi->randomString(4);
        $kode_sekolah  = $nama_aktivasi;

        $nohp_email_admin = $nohp_email_add . "#admin";
        $nohp_email_topup = $nohp_email_add . "#topup";
        $nohp_email_pembayaran = $nohp_email_add . "#pembayaran";

        $insert_admin  = "insert into tbl_member_account (noid,nama,alamat,nohp_email,tipe,jenis,noid_act,noid_mit,noid_submit,status,reg_date,saldo,"
        . "provinsi,kota_kabupaten,kecamatan,kelurahan,rt,rw,kodepos,nik,tgl_lahir,provinsi_value,kota_kabupaten_value,kecamatan_value,kelurahan_value,hak_saldo) values"
        . "('$noid_admin','Padanan Admin $nama_add','$alamat_add','$nohp_email_admin','M3',$jenis_tbl,'$noid_add_m2','$noid_ca','$noid_subca',1,now(),0,"
        . "'$provinsi','$kota_kabupaten','$kecamatan','$kelurahan','$rt','$rw','$kodepos','$nik_add','$tgl_lahir_add','$provinsi_value','$kota_kabupaten_value','$kecamatan_value','$kelurahan_value',$hak_saldo);";

        $insert_topup  = "insert into tbl_member_account (noid,nama,alamat,nohp_email,tipe,jenis,noid_act,noid_mit,noid_submit,status,reg_date,saldo,"
        . "provinsi,kota_kabupaten,kecamatan,kelurahan,rt,rw,kodepos,nik,tgl_lahir,provinsi_value,kota_kabupaten_value,kecamatan_value,kelurahan_value,hak_saldo) values"
        . "('$noid_topup','Padanan Topup $nama_add','$alamat_add','$nohp_email_topup','M3',$jenis_tbl,'$noid_add_m2','$noid_ca','$noid_subca',1,now(),0,"
        . "'$provinsi','$kota_kabupaten','$kecamatan','$kelurahan','$rt','$rw','$kodepos','$nik_add','$tgl_lahir_add','$provinsi_value','$kota_kabupaten_value','$kecamatan_value','$kelurahan_value',$hak_saldo);";

        $insert_pembayaran  = "insert into tbl_member_account (noid,nama,alamat,nohp_email,tipe,jenis,noid_act,noid_mit,noid_submit,status,reg_date,saldo,"
        . "provinsi,kota_kabupaten,kecamatan,kelurahan,rt,rw,kodepos,nik,tgl_lahir,provinsi_value,kota_kabupaten_value,kecamatan_value,kelurahan_value,hak_saldo) values"
        . "('$noid_pembayaran','Padanan Pembayaran $nama_add','$alamat_add','$nohp_email_pembayaran','M3',$jenis_tbl,'$noid_add_m2','$noid_ca','$noid_subca',1,now(),0,"
        . "'$provinsi','$kota_kabupaten','$kecamatan','$kelurahan','$rt','$rw','$kodepos','$nik_add','$tgl_lahir_add','$provinsi_value','$kota_kabupaten_value','$kecamatan_value','$kelurahan_value',$hak_saldo);";
        
        $db->singleRow($insert_admin);
        $db->singleRow($insert_topup);
        $db->singleRow($insert_pembayaran);

        $insert_sekolah = "INSERT INTO tbl_sekolah (kode_sekolah, nama_sekolah, alamat, no_telp, status, limit_max, noid_admin, noid_topup, noid_pembayaran) 
                           VALUES ('$kode_sekolah','$nama_add','$alamat_add','$nohp_email_add',1, '$limit_max', '$noid_admin', '$noid_topup' ,'$noid_pembayaran')";
        $dbSekolah->singleRow($insert_sekolah);

        $db->singleRow("insert into tbl_act_card (noid,alias_act) values ('$noid_add_m2','$nama_aktivasi')");
        $msg_out = "Registrasi $jenis $tipe " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
        . "Website " . $konfig->urlWebLogin() . " USERNAME=$username_add PASSWORD=$pass_add KODE AKTIVASI SEKOLAH $nama_aktivasi";

    } else {
        $msg_out = "Registrasi $jenis $tipe " . $konfig->namaAplikasi() . " telah berhasil. NOID:$noid_add. "
        . "Website " . $konfig->urlWebLogin() . " USERNAME=$username_add PASSWORD=$pass_add";
    }

    $sql = "BEGIN TRANSACTION;"
        . "insert into tbl_member_account (noid,nama,alamat,nohp_email,tipe,jenis,noid_act,noid_mit,noid_submit,status,reg_date,saldo,"
        . "provinsi,kota_kabupaten,kecamatan,kelurahan,rt,rw,kodepos,nik,tgl_lahir,provinsi_value,kota_kabupaten_value,kecamatan_value,kelurahan_value,hak_saldo) values"
        . "('$noid_add','$nama_add','$alamat_add','$nohp_email_add','$tipe',$jenis_tbl,'$noid','$noid_ca','$noid_subca',1,now(),0,"
        . "'$provinsi','$kota_kabupaten','$kecamatan','$kelurahan','$rt','$rw','$kodepos','$nik_add','$tgl_lahir_add','$provinsi_value','$kota_kabupaten_value','$kecamatan_value','$kelurahan_value',$hak_saldo);"
        . "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,kode_sekolah,grup) values "
        . "('WEB','$noid_add','$username_add',now(),now(),'$pass_add','$nama_add','$nohp_email_add','$kode_sekolah','$group');"
        . "insert into log_message(nohp_email,interface,msg,secret) values ('$nohp_email_add','$tipe_message','$msg_out',1);"
        . "COMMIT;";

    $db->singleRow($sql);

    $response = array(
        'response_code'    => '0000',
        'response_message' => "Sukses Registrasi $jenis $tipe",
        'saldo'            => $saldo_member,
    );
} else {
    $error->regAccountNohpEmailTerdaftar($saldo_member);
}
$reply = json_encode($response);
