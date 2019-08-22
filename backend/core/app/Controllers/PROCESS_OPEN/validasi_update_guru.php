<?php

$dbSekolah    = new Models\DbSekolah();
$appid        = $jreq->appid;
$token_aktivasi   = strtoupper($jreq->token_aktivasi);
$arr_cek_validasi = $db->singleRow("SELECT id,noid_agen,tipe_agen FROM log_validasi WHERE noid = '$nohp_email' "
    . "and kode_validasi = '$token_aktivasi' and status = 9 and date(waktu) = date(now()) order by id desc limit 1");
$arr_guru     = $dbSekolah->cekId('tbl_guru','nohp',$nohp_email);
if ($arr_cek_validasi != false && $arr_guru != false) {
	$password = $jreq->password;
	$email    = $jreq->email;
	$nama_add = $arr_guru->nama;
	$id_sekolah_ = $arr_guru->id_sekolah;
	$arr_sekolah = $dbSekolah->cekId('tbl_sekolah','id',$id_sekolah_);
	$id_sekolah = $arr_sekolah->kode_sekolah;
	
	$sql_cek_noid = "SELECT b.noid FROM tbl_member_channel a 
LEFT JOIN tbl_member_account b on a.noid = b.noid 
 WHERE kode_sekolah = '$id_sekolah' AND b.tipe = 'M2' LIMIT 1";
	$data_m2 = $db->singleRow($sql_cek_noid);
	$alamat_add = $arr_guru->alamat;
	$alamat = $arr_guru->alamat;

	//Insert into member channel for guru

    $jenis       = 'MEMBER';
    $noid        = $data_m2->noid;
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
        $pass_add         = strtoupper(trim($jreq->password)); //ada password untuk mobile
        $appid            = preg_replace("/[^a-zA-Z0-9]/", "", $jreq->appid);
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
    //$nohp_email_ = $awal_noid . "#" . $nohp_email;
    $arr_cek     = $db->cekNohpMember($nohp_email);

    if (!isset($arr_cek->id)) {
        if ($aturan == 'M1M2' || $aturan == 'M2M3') {
            if ($jenis == 'MEMBER') {

                if ($tipe == 'M2' && $aturan == 'M1M2') {
                    $prefix_ca    = substr($noid, 0, 3);
                    $sql_count    = "select count(id) as jml from tbl_member_account where tipe = '$tipe' and substring(noid from 1 for 3) = '$prefix_ca'";
                    $arr_count    = $db->singleRow($sql_count);
                    $prefix_subca = $prefix_ca . str_pad($arr_count->jml + 1, 4, "0", STR_PAD_LEFT);
                    $noid_add     = $prefix_subca . '000000000';
                    $noid_ca      = $prefix_ca . '0000000000000';
                    $noid_subca   = $noid_add;
                } elseif ($tipe == 'M3' && $aturan == 'M2M3') {
                    $prefix_ca     = substr($noid, 0, 3);
                    $prefix_subca  = substr($noid, 0, 7);
                    $sql_count     = "select count(id) as jml from tbl_member_account where tipe = '$tipe' and substring(noid from 1 for 7) = '$prefix_subca'";
                    $arr_count     = $db->singleRow($sql_count);
                    $prefix_member = str_pad($arr_count->jml + 1, 9, "0", STR_PAD_LEFT);
                    $noid_add      = $prefix_subca . $prefix_member;
                    $noid_ca       = $prefix_ca . '0000000000000';
                    $noid_subca    = $prefix_subca . '000000000';
                    $nohp_email_   = $nohp_email;//$prefix_subca . "#$nohp_email";
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
            . "email) values"
            . "('$noid_add','$nama_add','$alamat_add','$nohp_email_','$tipe',$jenis_tbl,'$noid','$noid_ca','$noid_subca',1,now(),0,"
            . "'$email');"
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
            . "update tbl_member_account set noid='$noid_add',nama='$nama_add',"
            . "nohp_email='$nohp_email',tipe='$tipe',jenis=$jenis_tbl,noid_act='$noid',noid_mit='$prefix_ca',"
            . "noid_submit='$prefix_subca',status=1,reg_date=now(),"
            . "email='$email' where id=$id_add;"
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

	// $sql_insert = "UPDATE tbl_guru SET 
	// 			appid = '$appid' ,
	// 			email = '$email' ,
	// 			is_registered = '1' , 
	// 			password = '$password', 
	// 			reg_date = NOW() 
	// 			WHERE nohp = '$nohp_email'";

	// $dbSekolah->singleRow($sql_insert);
	// $response = array(
	// 	'response_code' => '0000',
	// 	'response_message' => 'Registrasi Guru Berhasil, Silahkan Login'
	// );

} else {
    $response = array(
        'response_code'    => '0091',
        'response_message' => 'KODE VALIDASI yang anda masukkan salah atau sudah berbeda tanggal',
    );
}
$reply = json_encode($response);