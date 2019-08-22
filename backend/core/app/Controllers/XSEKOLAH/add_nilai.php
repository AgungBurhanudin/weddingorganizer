<?php

$dbSekolah  = new Models\DbSekolah;
$fungsi     = new Libraries\Fungsi();
$nohp       = $jreq->nohp;
$arr_guru   = $dbSekolah->cekId('tbl_guru', 'nohp', $nohp);
$id_sekolah = $arr_guru->id_sekolah; //$jreq->id_sekolah;
$id_guru    = $arr_guru->id;

$id_siswa     = $jreq->detail->id_siswa;
$jenis_nilai  = $jreq->detail->jenis_nilai;
$matpel       = $jreq->detail->matpel;
$nilai        = $jreq->detail->nilai;
$keterangan   = isset($jreq->detail->keterangan) ? $jreq->detail->keterangan : "";


if (is_array($id_siswa)) {
	for($ii = 0; $ii < count($id_siswa); $ii++){
		$id_siswa     = $id_siswa[$ii];
		$jenis_nilai  = $jenis_nilai[$ii];
		$matpel       = $matpel[$ii];
		$nilai        = $nilai[$ii];
    	$query = "INSERT INTO $table (id_sekolah, id_siswa, jenis_nilai, id_matpel, nilai, keterangan, id_guru) "
		        . " VALUES ('$id_sekolah','$id_siswa' , '$jenis_nilai', '$matpel', '$nilai',' $keterangan', '$id_guru')"
		        . "RETURNING id;";
		$arr = $dbSekolah->singlerow($query);
	    if (isset($arr->id)) {
	        $msg .= "Berhasil Menambah Nilai Siswa";
	    } else {
	        $msg .= "Gagal menambah nilai siswa";
	    }


	}
} else {
    $query = "INSERT INTO $table (id_sekolah, id_siswa, jenis_nilai, id_matpel, nilai, keterangan, id_guru) "
        . " VALUES ('$id_sekolah','$id_siswa' , '$jenis_nilai', '$matpel', '$nilai',' $keterangan', '$id_guru')"
        . "RETURNING id;";

    $arr = $dbSekolah->singlerow($query);

    if (isset($arr->id)) {
        $response = array(
            'response_code'    => '0000',
            'response_message' => 'Tambah Nilai Berhasil',
        );
    } else {
        $response = array(
            'response_code'    => '0099',
            'response_message' => 'Tambah Nilai Gagal',
        );
    }
    $reply = json_encode($response);
}
