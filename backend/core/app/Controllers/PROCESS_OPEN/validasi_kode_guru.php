<?php

$dbSekolah = new Models\DbSekolah;

$kode_validasi = $jreq->kode_validasi;

$arr_cek_validasi = $db->singleRow("SELECT id FROM log_validasi WHERE noid = '$nohp_email' "
    . "and kode_validasi = '$kode_validasi' and status = 0 and waktu > now() - interval '600 seconds'");

$sql_cek_guru = "SELECT * FROM tbl_guru WHERE nohp = '$nohp_email'";

$token_aktivasi = $fungsi->randomString(12);
if ($arr_cek_validasi != false) {
    $arr_2 = $dbSekolah->singleRow($sql_cek_guru);
        $detail_arr = array(
            'nama'                 => $arr_2->nama,
			'nohp'			       => $nohp_email,
			'email'                => $arr_2->email
        );
		$code = '0000';
		if($arr_2->is_registered == 1){
			$code = '1111';
		}
        $response = array(
            'response_code'    => $code,
            'response_message' => 'DATA MEMBER TERSEDIA',
            'token_aktivasi'   => $token_aktivasi,
            'data'             => $detail_arr
        );
    $id_validasi = $arr_cek_validasi->id;
    $db->singleRow("update log_validasi set status = 9, kode_validasi = '$token_aktivasi' where id=$id_validasi;");
} else {
    $response = array(
        'response_code'    => '0091',
        'response_message' => 'KODE VALIDASI yang anda masukkan salah atau sudah lebih dari 5 menit',
    );
}

$reply = json_encode($response);