<?php

$dbSekolah  = new Models\DbSekolah;
$fungsi     = new Libraries\Fungsi();
$nohp       = $jreq->nohp;
$arr_guru    = $dbSekolah->cekId('tbl_guru','nohp', $nohp);
$id_sekolah  = $arr_guru->id_sekolah;//$jreq->id_sekolah;
$id_guru    = $arr_guru->id;
$id_jadwal  = isset($jreq->id_jadwal) ? $jreq->id_jadwal : "";

//Cari Per Siswa
if ($id_jadwal != "" || !empty($id_jadwal)) {
    $sql = "SELECT p.id AS p_id, c.id AS id_siswa, c.nis, c.nama, d.status as absen
            FROM   tbl_jadwal p
            LEFT   JOIN LATERAL jsonb_array_elements(p.siswa->'siswa') pc(child) ON TRUE
            LEFT   JOIN tbl_siswa c ON c.id = pc.child::text::int 
			LEFT   JOIN tbl_absensi d ON c.id = d.siswa AND p.id = d.id_jadwal  
            WHERE p.id = $id_jadwal order by c.nama; ";
			//echo $sql;

    $data_siswa = $dbSekolah->multipleRow($sql);
    if (!empty($data_siswa) || $data_siswa != "") {
        $jadwal = array();
		$no = 1;
        foreach ($data_siswa as $key => $value) {
            $jadwal[] = array(
                'no'   => $no++,
				'id_siswa' => $value->id_siswa,
                'nis'  => $value->nis,
                'nama' => $value->nama,
                'absen' => $value->absen,
            );
        }
        $response = array(
            'response_code'    => '0000',
            'response_message' => 'Data Siswa Di temukan',
            'detail'           => $jadwal,
        );
    } else {
        $response = array(
            'response_code'    => '0404',
            'response_message' => 'Data Siswa  Tidak Di temukan',
        );
    }
} else {
    $response = array(
        'response_code'    => '0404',
        'response_message' => 'Id Jadwal Belum di masukan',
    );
}
$reply = json_encode($response);
