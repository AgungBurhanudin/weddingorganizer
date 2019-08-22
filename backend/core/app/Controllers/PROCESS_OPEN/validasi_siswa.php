<?php

$dbSekolah = new Models\DbSekolah();
$fungsi    = new Libraries\Fungsi();

$nama      = strtoupper($jreq->detail->nama);
$tgl_lahir = $jreq->detail->tanggal_lahir;

    $query_cek_siswa = "SELECT * FROM tbl_siswa WHERE upper(nama) = '$nama' AND tanggal_lahir = '$tgl_lahir'";
    $arr_siswa       = $dbSekolah->singleRow($query_cek_siswa);
    if (empty($arr_siswa) || !isset($arr_siswa->nis) || $arr_siswa == "") {

        $response = array(
            'response_code'    => '0099',
            'response_message' => 'Data Siswa yang anda daftarkan, tidak terdaftar dalam aplikasi ini',
        );
        die(json_encode($response));
    } else {
        $nis                      = $arr_siswa->nis;
        $id_s                     = $arr_siswa->id_sekolah;
        $cek_sekolah              = $dbSekolah->cekId('tbl_sekolah', 'id', $id_s);
        $id_sekolah               = $cek_sekolah->kode_sekolah;
        $query_cek_member_channel = "SELECT * FROM tbl_member_channel WHERE kode_sekolah = '$id_sekolah' AND nis = '$nis'";
        $arr_cek_member_channel   = $db->singleRow($query_cek_member_channel);
		
        if (!empty($arr_cek_member_channel)) {
			//cek m2 nya apakah sama atau tidak , kalau sama lanjut kalau beda hubungi administrator
			$noid_m2 = $arr_cek_member_channel->noid;
			$data_m2 = $db->singleRow("SELECT a.nohp_email,a.noid FROM tbl_member_account a LEFT JOIN tbl_member_channel b on a.noid = b.noid WHERE a.noid = '$noid_m2' AND b.interface = 'MOBILE'");
			
			if (strpos($data_m2->nohp_email, '#') !== false) {				
				$nohp_m2 = $fungsi->getNoHpEmail($data_m2->nohp_email, 'NOHP');
			}else{
				$nohp_m2 = $data_m2->nohp_email;
			}
			if($nohp_m2 == $nohp_email){
				$response = array(
					'response_code'    => '0000',
					'response_message' => 'Data Siswa di temukan',
					'detail'           => array(
						'nama_wali' => $arr_siswa->nama_wali,
						'email_wali' => $arr_siswa->email_wali,
					)
				);
				die(json_encode($response));
			}else{
				$response = array(
					'response_code'    => '0402',
					'response_message' => 'Data Siswa yang anda masukan sudah terdaftar, Silahkan hubungi pihak sekolah untuk verifikasi data',
				);
				die(json_encode($response));
			}
        } else {
            $response = array(
                'response_code'    => '0000',
                'response_message' => 'Data Siswa di temukan',
                'detail'           => $arr_siswa,
            );
            die(json_encode($response));
        }
    }
