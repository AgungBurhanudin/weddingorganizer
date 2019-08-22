<?php

$dbSekolah = new Models\DbSekolah;
$fungsi = new Libraries\Fungsi();
$tanggal = date('Y-m-d'); 
$waktu   = date('H:i:s');
$id_nfc = $jreq->id_nfc;
$nohp = isset($jreq->nohp) ? $jreq->nohp : "";

$cek_nfc = $db->singleRow("SELECT * FROM tbl_member_channel WHERE UPPER(alias) = UPPER('$id_nfc') AND interface = 'NFC'");
if (isset($cek_nfc->noid)) {
    $kode_sekolah = $cek_nfc->kode_sekolah;
    $nis = $cek_nfc->nis;
    $cek_siswa = $dbSekolah->singleRow("SELECT a.* FROM tbl_siswa a LEFT JOIN tbl_sekolah b ON a.id_sekolah=b.id "
            . "WHERE a.nis= '$nis' AND b.kode_sekolah = '$kode_sekolah'");
    if (isset($cek_siswa->nis)) {
        $id_sekolah = $cek_siswa->id_sekolah;
        $id_siswa   = $cek_siswa->id;
        $query = "INSERT INTO tbl_absensi "
                . "(tanggal, waktu_mulai, waktu_selesai, status, id_sekolah, siswa, input_time, nfc_id) "
                . "VALUES "
                . "('$tanggal', '$waktu', '$waktu' ,'1', '$id_sekolah', '$id_siswa', now(), '$id_nfc') "
                . "RETURNING id";
//        echo $query;
//        die();
        $insert = $dbSekolah->singleRow($query);
        if(isset($insert->id)){
            $response = array(
                'response_code' => '0000',
                'response_message' => 'Berhasil Absensi',
                'detail' => $cek_siswa,
                'tanggal' => $tanggal,
                'waktu' => $waktu
            );
        }else{
            $response = array(
                'response_code' => '9999',
                'response_message' => 'Gagal Absensi 1 '. $id_nfc
            );
        }
    } else {
        $response = array(
            'response_code' => '9999',
            'response_message' => 'Gagal Absensi 2 '. $id_nfc
        );
    }
} else {
    $response = array(
        'response_code' => '9999',
        'response_message' => 'Gagal Absensi 3 '. $id_nfc
    );
}

$reply = json_encode($response);
