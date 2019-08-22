<?php

$dbSekolah = new Models\DbSekolah;
$fungsi = new Libraries\Fungsi();
$nohp = $jreq->nohp;
$arr_guru = $dbSekolah->cekId('tbl_guru', 'nohp', $nohp);
$id_sekolah = $arr_guru->id_sekolah; //$jreq->id_sekolah;
$id_guru = $arr_guru->id;
$id_jadwal = isset($jreq->detail->id_jadwal) ? $jreq->detail->id_jadwal : "";
$id_siswa = $jreq->detail->id_siswa;
$status = $jreq->detail->status;
$tanggal = $jreq->detail->tanggal;
$keterangan = isset($jreq->detail->keterangan) ? $jreq->detail->keterangan : "";

$arr_jadwal = $dbSekolah->cekId('tbl_jadwal', 'id', $id_jadwal);
$waktu_mulai = $arr_jadwal->waktu_mulai;
$waktu_selesai = $arr_jadwal->waktu_selesai;

$cek_absensi = $dbSekolah->singleRow("SELECT * FROM tbl_absensi WHERE id_jadwal = $id_jadwal and siswa = $id_siswa");
if (isset($cek_absensi->id)) {
    $sql_update = "UPDATE tbl_absensi SET waktu_mulai = '$waktu_mulai', waktu_selesai = '$waktu_selesai', status = $status 
				   WHERE siswa = $id_siswa AND id_jadwal = $id_jadwal RETURNING id";
    $query = $dbSekolah->singleRow($sql_update);
} else {
    $sql_insert = "INSERT INTO tbl_absensi (id_jadwal, tanggal, waktu_mulai, waktu_selesai, status, siswa, input_time, keterangan, id_sekolah) 
				VALUES ('$id_jadwal', '$tanggal', '$waktu_mulai', '$waktu_selesai', '$status', '$id_siswa', now(), '$keterangan', '$id_sekolah')
				RETURNING id";
    $query = $dbSekolah->singleRow($sql_insert);
}
if (isset($query->id)) {
    $response = array(
        'response_code' => '0000',
        'response_message' => 'Berhasil Absen'
    );
} else {
    $response = array(
        'response_code' => '9999',
        'response_message' => 'Gagal Absen'
    );
}
$reply = json_encode($response);
