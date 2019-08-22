<?php

$kode_validasi = $jreq->kode_validasi;

$arr_cek_validasi = $db->singleRow("SELECT id FROM log_validasi WHERE noid = '$nohp_email' "
        . "and kode_validasi = '$kode_validasi' and status = 0 and waktu > now() - interval '600 seconds'");

$token_aktivasi = $fungsi->randomString(12);
if ($arr_cek_validasi != FALSE) {
    $arr = $db->cekNohpMember($nohp_email);
    if (isset($arr->id)) {
        $detail_arr = array(
            'nama' => $arr->nama,
			'email' => $arr->email,
            'nik' => $arr->nik,
            'tgl_lahir' => $arr->tgl_lahir,
            'alamat' => $arr->alamat,
            'provinsi' => $arr->provinsi,
            'provinsi_value' => $arr->provinsi_value,
            'kota_kabupaten' => $arr->kota_kabupaten,
            'kota_kabupaten_value' => $arr->kota_kabupaten_value,
            'kecamatan' => $arr->kecamatan,
            'kecamatan_value' => $arr->kecamatan_value,
            'kelurahan' => $arr->kelurahan,
            'kelurahan_value' => $arr->kelurahan_value,
            'rt' => $arr->rt,
            'rw' => $arr->rw,
            'kodepos' => $arr->kodepos
            );
        $response = array(
            'response_code' => '0000',
            'response_message' => 'DATA MEMBER TERSEDIA',
            'token_aktivasi' => $token_aktivasi,
            'data' => $detail_arr
        );
    } else {
        $detail_arr = array(
            'nama' => '',
            'nik' => '',
            'tgl_lahir' => '',
            'alamat' => '',
            'provinsi' => '',
            'kota_kabupaten' => '',
            'kecamatan' => '',
            'kelurahan' => '',
            'provinsi_value' => '',
            'kota_kabupaten_value' => '',
            'kecamatan_value' => '',
            'kelurahan_value' => '',
            'rt' => '',
            'rw' => '',
            'kodepos' => ''
            );
        $response = array(
            'response_code' => '0000',
            'response_message' => 'DATA MEMBER TIDAK TERSEDIA',
            'token_aktivasi' => $token_aktivasi,
            'data' => $detail_arr
        );
    }
    $id_validasi = $arr_cek_validasi->id;
    $db->singleRow("update log_validasi set status = 9, kode_validasi = '$token_aktivasi' where id=$id_validasi;");
} else {
    $response = array(
        'response_code' => '0091',
        'response_message' => 'KODE VALIDASI yang anda masukkan salah atau sudah lebih dari 5 menit'
    );
}

$reply = json_encode($response);
