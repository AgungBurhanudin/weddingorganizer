<?php

$dbSekolah = new Models\DbSekolah;

$kode_validasi = $jreq->kode_validasi;

$arr_cek_validasi = $db->singleRow("SELECT id FROM log_validasi WHERE noid = '$nohp_email' "
    . "and kode_validasi = '$kode_validasi' and status = 0 and waktu > now() - interval '600 seconds'");

$token_aktivasi = $fungsi->randomString(12);
if ($arr_cek_validasi != false) {
    $arr_sekolah = $dbSekolah->multipleRow("SELECT kode_sekolah, nama_sekolah FROM tbl_sekolah");

    $response = array(
        'response_code'    => '0000',
        'response_message' => 'Kode Validasi OK',
        'kode_validasi'    => $kode_validasi,
        'detail'           => $arr_sekolah
    );
} else {
    $response = array(
        'response_code'    => '0091',
        'response_message' => 'KODE VALIDASI yang anda masukkan salah atau sudah lebih dari 5 menit',
    );
}

$reply = json_encode($response);
