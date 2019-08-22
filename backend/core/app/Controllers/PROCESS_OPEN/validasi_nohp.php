<?php

$dbSekolah    = new Models\DbSekolah();
$kode_sekolah = isset($jreq->id_sekolah) ? $jreq->id_sekolah : 0;
$noid_agen    = "";
$tipe         = "";
$key_validasi = $fungsi->randomNumber(4);
$message      = "$nama_aplikasi, KODE VALIDASI = $key_validasi . Rahasiakan kode validasi untuk keamanan transaksi. Kode dapat digunakan dalam 5 menit.";
if (is_numeric($nohp_email) == true) {
    $jenis_msg = 'NOHP';
} else {
    $jenis_msg = 'EMAIL';
    $cek_account_absen = $db->singleRow("SELECT a.noid,b.kode_sekolah FROM tbl_member_account a LEFT JOIN tbl_member_channel b on a.noid=b.noid WHERE UPPER(b.alias) = '$nohp_email' AND a.tipe ='M3'");
    if(isset($cek_account_absen->noid)){
        $response  = array(
            'response_code'    => '5555',
            'response_message' => 'Login sebagai user absensi',
            'tipe'             => 'ABSEN',
            'noid'             => $cek_account_absen->noid,
            'id_sekolah'       => $cek_account_absen->kode_sekolah
        );
        die(json_encode($response));        
    }
    $response  = array(
        'response_code'    => '8888',
        'response_message' => 'No Hp yang Anda masukan tidak valid',
    );
    die(json_encode($response));
}
//Cek No Hp apakah sudah terdaftar sebagai tidak M3 atau belum
$cek_account_not_m2 = $db->singleRow("SELECT a.noid,b.kode_sekolah FROM tbl_member_account a LEFT JOIN tbl_member_channel b on a.noid=b.noid WHERE a.nohp_email = '$nohp_email' AND a.tipe != 'M3'");
if(isset($cek_account_not_m2->noid)){	
    $response  = array(
        'response_code'    => '9999',
        'response_message' => 'No Hp sudah terdaftar sebagai No Hp Sekolah',
    );
    die(json_encode($response));
}

//Cek No Hp dan Kode Sekolah apakah sudah terdaftar di member channel dan account M3 atau belum??
$cek_account = $db->singleRow("SELECT a.noid,b.kode_sekolah FROM tbl_member_account a LEFT JOIN tbl_member_channel b on a.noid=b.noid WHERE a.nohp_email = '$nohp_email' LIMIT 1");
if (isset($cek_account->noid)) {
    //di member account ada
    if ($cek_account->kode_sekolah === $kode_sekolah) {
        //di member account ada dan kode sekolah sama
        $param = array(
        	'nohp_email' => $nohp_email,
        	'kode_agen'  => $cek_account->kode_sekolah
        );
        $param = json_encode($param);
        
		//cek M2 atau cek noid sekolah
		$cek_member_2 = $db->singleRow("SELECT noid FROM tbl_act_card WHERE alias_act = '$kode_sekolah'");
		$noid_agen    = isset($cek_member_2->noid) ? $cek_member_2->noid : "";
		$tipe         = isset($cek_member_2->noid) ? "M2" : "";

        $sql = "BEGIN TRANSACTION;"
            . "insert into log_validasi (noid,djson_validasi,kode_validasi, noid_agen, tipe_agen) values"
            . "('$nohp_email','$param','$key_validasi','$noid_agen','$tipe');"
            . "COMMIT;";

        $db->singleRow($sql);
        $db->kirimMessageUnreg($nohp_email, $message);

        $response = array(
            'response_code'    => '0000',
            'response_message' => 'Kode Validasi ' . $key_validasi . ' sedang dikirim ke ' . $jenis_msg . ' ' . $nohp_email . ' KODE DAPAT DIGUNAKAN DALAM 5 MENIT',
            'kode_sekolah'     => $kode_sekolah,
        );
    } else {
        //di member account ada tapi kode sekolah beda
        $response = array(
            'response_code'    => '0123',
            'response_message' => $jenis_msg . ' Anda sudah terdaftar di sekolah lain.',
        );
        die(json_encode($response));
    }
} else {
    //di member account tidak ada

    //1. Cek di Table Siswa Database Sekolah
    $cek_wali = $dbSekolah->singleRow("SELECT a.*,b.kode_sekolah FROM tbl_siswa a LEFT JOIN tbl_sekolah b on a.id_sekolah = b.id WHERE a.nohp_wali = '$nohp_email'");
	
    if (isset($cek_wali->id)) {
        // Wali ada

        //2. Cek Apakah Sekolah Sama
            // Wali ada dan Sekolah Sesuai dengan aplikasinya
	        $param = array(
	        	'nohp_email' => $nohp_email,
	        	'kode_agen'  => $cek_wali->kode_sekolah
	        );
	        $param = json_encode($param);
	        
			//cek M2 atau cek noid sekolah
			$cek_member_2 = $db->singleRow("SELECT noid FROM tbl_act_card WHERE alias_act = '$kode_sekolah'");
			$noid_agen    = isset($cek_member_2->noid) ? $cek_member_2->noid : "";
			$tipe         = isset($cek_member_2->noid) ? "M2" : "";

            $sql = "BEGIN TRANSACTION;"
                . "insert into log_validasi (noid,djson_validasi,kode_validasi, noid_agen, tipe_agen) values"
                . "('$nohp_email','$param','$key_validasi','$noid_agen','$tipe');"
                . "COMMIT;";

            $db->singleRow($sql);
            $db->kirimMessageUnreg($nohp_email, $message);

            $response = array(
                'response_code'    => '0000',
                'response_message' => 'Kode Validasi ' . $key_validasi . ' sedang dikirim ke ' . $jenis_msg . ' ' . $nohp_email . ' KODE DAPAT DIGUNAKAN DALAM 5 MENIT',
                'kode_sekolah'     => $kode_sekolah,
            );
    } else {
        //Wali tidak ada di data sekolah
		$cek_m2 = $db->singleRow("SELECT * FROM tbl_act_card WHERE alias_act = '$kode_sekolah'");
		if(isset($cek_m2->noid)){
			$noid_agen = $cek_m2->noid;
			$tipe = "M2";
		}
		
        $sql = "BEGIN TRANSACTION;"
            . "insert into log_validasi (noid,djson_validasi,kode_validasi, noid_agen, tipe_agen) values"
            . "('$nohp_email','$param','$key_validasi','$noid_agen','$tipe');"
            . "COMMIT;";

        $db->singleRow($sql);
        $db->kirimMessageUnreg($nohp_email, $message);

        $response = array(
            'response_code'    => '0000',
            'response_message' => 'Kode Validasi ' . $key_validasi . ' sedang dikirim ke ' . $jenis_msg . ' ' . $nohp_email . ' KODE DAPAT DIGUNAKAN DALAM 5 MENIT',
            'kode_sekolah'     => $kode_sekolah,
        );
    }
}
$reply = json_encode($response);
