<?php

$dbSekolah = new Models\DbSekolah;

$kode_validasi = $jreq->kode_validasi;
$id_sekolah = isset($jreq->id_sekolah) ? $jreq->id_sekolah : "";
$w_sekolah = "";
if($id_sekolah != ""){
    $arr_sekolah = $dbSekolah->cekId('tbl_sekolah','kode_sekolah',$id_sekolah);
    $id_sekolah_ = $arr_sekolah->id;
    $w_sekolah   = "AND id_sekolah = '$id_sekolah_'";
}

$arr_cek_validasi = $db->singleRow("SELECT id FROM log_validasi WHERE noid = '$nohp_email' "
    . "and kode_validasi = '$kode_validasi' and status = 0 and waktu > now() - interval '600 seconds'");

$sql_cek_wali = "SELECT * FROM tbl_siswa WHERE nohp_wali = '$nohp_email' $w_sekolah";
$sql_cek_guru = "SELECT * FROM tbl_guru WHERE nohp = '$nohp_email' $w_sekolah";

$data_wali = $dbSekolah->singleRow($sql_cek_wali);
$data_guru = $dbSekolah->singleRow($sql_cek_guru);
$tipe = "WALI"; 
if(isset($data_wali->id) && isset($data_guru->id)){
    $tipe = "WALI_GURU";
}else if(isset($data_wali->id) && !isset($data_guru->id)){
    $tipe = "WALI";
}else if(!isset($data_wali->id) && isset($data_guru->id)){
    $tipe = "GURU";
}
// echo "$sql_cek_wali";
// exit();
// die();
$token_aktivasi = $fungsi->randomString(12);
if ($arr_cek_validasi != false) {
    if($tipe == "GURU"){
        $code = '0000';
        $message = "Data Guru Tersedia";
        if($data_guru->is_registered == 1){
            $code = '1111';
            $message = "Data Guru Sudah Teregistrasi";
        }
        $email = $data_guru->email;
        $id_validasi = $arr_cek_validasi->id;
        $db->singleRow("update log_validasi set status = 9, kode_validasi = '$token_aktivasi', tipe_agen='M2' where id=$id_validasi;");
        $response = array(
            'response_code'    => $code,
            'response_message' => 'DATA MEMBER TERSEDIA',
            'tipe'             => $tipe,
            'token_aktivasi'   => $token_aktivasi,
            'data'             => $data_guru
        );
    }else{

        $arr   = $db->cekNohpMember($nohp_email);
        $arr_2 = $dbSekolah->singleRow($sql_cek_wali);
        // print_r($arr_2);
        if (isset($arr->id)) {
            $detail_arr = array(
                'nama'                 => $arr->nama,
                'nik'                  => $arr->nik,
                'tgl_lahir'            => $arr->tgl_lahir,
                'alamat'               => $arr->alamat,
                'provinsi'             => $arr->provinsi,
                'provinsi_value'       => $arr->provinsi_value,
                'kota_kabupaten'       => $arr->kota_kabupaten,
                'kota_kabupaten_value' => $arr->kota_kabupaten_value,
                'kecamatan'            => $arr->kecamatan,
                'kecamatan_value'      => $arr->kecamatan_value,
                'kelurahan'            => $arr->kelurahan,
                'kelurahan_value'      => $arr->kelurahan_value,
                'rt'                   => $arr->rt,
                'rw'                   => $arr->rw,
                'kodepos'              => $arr->kodepos,
    			'nohp'			   	   => $nohp_email,
    			'email'				   => $arr->email
            );
            $response = array(
                'response_code'    => '0000',
                'response_message' => 'DATA MEMBER TERSEDIA',
                'tipe'             => $tipe,
                'token_aktivasi'   => $token_aktivasi,
                'data'             => $detail_arr,
    			'data_siswa'	   => $arr_2
            );
        } else if (isset($arr_2->nama_wali)) {
            $detail_arr = array(
                'nama'                 => $arr_2->nama_wali,
                'nik'                  => '',
                'tgl_lahir'            => '',
                'alamat'               => '',
                'provinsi'             => '',
                'kota_kabupaten'       => '',
                'kecamatan'            => '',
                'kelurahan'            => '',
                'provinsi_value'       => '',
                'kota_kabupaten_value' => '',
                'kecamatan_value'      => '',
                'kelurahan_value'      => '',
                'rt'                   => '',
                'rw'                   => '',
                'kodepos'              => '',
    			'nohp'			       => $nohp_email,
    			'email'                => $arr_2->email_wali
            );
            $response = array(
                'response_code'    => '1111',
                'response_message' => 'DATA MEMBER TERSEDIA',
                'tipe'             => $tipe,
                'token_aktivasi'   => $token_aktivasi,
                'data'             => $detail_arr,
    			'data_siswa'	   => $arr_2
            );
        } else {
            $detail_arr = array(
                'nama'                 => '',
                'nik'                  => '',
                'tgl_lahir'            => '',
                'alamat'               => '',
                'provinsi'             => '',
                'kota_kabupaten'       => '',
                'kecamatan'            => '',
                'kelurahan'            => '',
                'provinsi_value'       => '',
                'kota_kabupaten_value' => '',
                'kecamatan_value'      => '',
                'kelurahan_value'      => '',
                'rt'                   => '',
                'rw'                   => '',
                'kodepos'              => '',
    			'nohp'			       => $nohp_email
            );
            $response = array(
                'response_code'    => '0404',
                'response_message' => 'DATA MEMBER TIDAK TERSEDIA',
                'tipe'             => $tipe,
                'token_aktivasi'   => $token_aktivasi,
                'data'             => $detail_arr
            );
        }
        $id_validasi = $arr_cek_validasi->id;
        $db->singleRow("update log_validasi set status = 9, kode_validasi = '$token_aktivasi', tipe_agen='M2' where id=$id_validasi;");
    }
} else {
    $response = array(
        'response_code'    => '0091',
        'response_message' => 'KODE VALIDASI yang anda masukkan salah atau sudah lebih dari 5 menit',
    );
}

$reply = json_encode($response);
