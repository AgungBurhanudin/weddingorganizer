<?php

$dbSekolah   = new Models\DbSekolah;
$fungsi      = new Libraries\Fungsi();
$nohp        = $jreq->nohp;
$arr_guru    = $dbSekolah->cekId('tbl_guru','nohp', $nohp);
$id_sekolah  = $arr_guru->id_sekolah;//$jreq->id_sekolah;
//$id_sekolah  = $jreq->id_sekolah;
$arr_guru    = $dbSekolah->cekId('tbl_guru','nohp', $nohp);

$arr_guru    = $dbSekolah->cekId('tbl_guru','nohp', $nohp);
$id_sekolah  = $arr_guru->id_sekolah;//$jreq->id_sekolah;
$id_sekolah  = $jreq->id_sekolah;
$arr_guru    = $dbSekolah->cekId('tbl_guru','nohp', $nohp);
$id_guru     = $arr_guru->id;
$tanggal     = isset($jreq->tanggal) ? $jreq->tanggal : date('Y-m-d');
$hari        = $fungsi->getNumberOfDay($tanggal);
//Cari Per Siswa
$sql = "SELECT a.id,a.hari,a.waktu_mulai,a.waktu_selesai,a.semester,a.tahun,b.nama_matpel,c.nama AS nama_guru,d.nama_sekolah,
                    jsonb_array_length(a.siswa->'siswa') AS jumlah_siswa 
                    FROM tbl_jadwal a
                    LEFT JOIN tbl_matpel b on a.id_matpel  = b.id
                    LEFT JOIN tbl_guru c on a.id_guru = c.id
                    LEFT JOIN tbl_sekolah d on a.id_sekolah = d.id
                    WHERE a.status_aktif = 1 AND a.id_sekolah = $id_sekolah AND a.id_guru = $id_guru AND a.hari = '$hari'
                     ORDER BY a.hari,a.waktu_mulai ASC; ";
					 //echo $sql;

$data_jadwal = $dbSekolah->multipleRow($sql);
if (!empty($data_jadwal) || $data_jadwal != "") {
    $jadwal = array();
    foreach ($data_jadwal as $key => $value) {
        $jadwal[$value->hari][] = array(
			'id'			=> $value->id,
            'tahun'         => $value->tahun,
            'semester'      => $value->semester,
            'waktu_mulai'   => $value->waktu_mulai,
            'waktu_selesai' => $value->waktu_selesai,
            'matpel'        => $value->nama_matpel,
            'jumlah_siswa'  => $value->jumlah_siswa,
        );
    }
    $response = array(
        'response_code'    => '0000',
        'response_message' => 'Data Jadwal Di temukan',
        'detail'           => $jadwal,
    );
} else {
    $response = array(
        'response_code'    => '0404',
        'response_message' => 'Jadwal Tidak Di temukan',
    );
}
$reply = json_encode($response);
