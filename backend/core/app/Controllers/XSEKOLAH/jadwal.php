<?php

$dbSekolah   = new Models\DbSekolah;
$noid        = $jreq->noid;
$data_member = $db->cekId('tbl_member_channel', 'noid', $noid);
$id_sekolah  = $data_member->kode_sekolah;
$cek_sekolah = $dbSekolah->cekId('tbl_sekolah','kode_sekolah',$id_sekolah);
$id_sekolah_ = $cek_sekolah->id;
$id_siswa    = (isset($jreq->detail->id_siswa)) ? $jreq->detail->id_siswa : '';
$status      = (isset($jreq->detail->status)) ? $jreq->detail->status : '';

$filter_search = "";
$filter_search .= $id_sekolah == '' ? '' : "and kode_sekolah = '$id_sekolah' ";

$sql_cek_siswa = "SELECT kode_sekolah, nis FROM tbl_member_channel WHERE noid = '$noid' AND interface = 'NFC' $filter_search";
$data_siswa    = $db->multipleRow($sql_cek_siswa);
if (empty($data_siswa)) {
    $response = array(
        'response_code'    => '0099',
        'response_message' => 'Data Siswa tidak di temukan',
    );
    die(json_encode($response));
}

if (count($data_siswa) > 1) {
    $data_siswa_ = array();
    foreach ($data_siswa as $key => $value) {
        $data_siswa_ = $dbSekolah->cekId('tbl_siswa', 'nis', $value->nis);
    }
    $response = array(
        'response_code'    => '0123',
        'response_message' => 'Data Siswa Di temukan, Silahkan pilih salah satu data siswa',
        'detail'           => $data_siswa_,
    );
    die(json_encode($response));
} else {
    $data_siswa_ = $dbSekolah->cekId('tbl_siswa', 'nis', $data_siswa[0]->nis);
    $id_siswa    = $data_siswa_->id;
}

if ($id_siswa == "" || empty($id_siswa)) {
    $response = array(
        'response_code'    => '0099',
        'response_message' => 'Anda belum memilih siswa',
    );
    die(json_encode($response));
}
$siswa = $id_siswa;
//$kelas = $jreq->detail->kelas;

//Cari Per Siswa
$sql = "SELECT a.hari,a.waktu_mulai,a.waktu_selesai,a.semester,a.tahun,b.nama_matpel,c.nama AS nama_guru,d.nama_sekolah
                    FROM tbl_jadwal a
                    LEFT JOIN tbl_matpel b on a.id_matpel  = b.id
                    LEFT JOIN tbl_guru c on a.id_guru = c.id
                    LEFT JOIN tbl_sekolah d on a.id_sekolah = d.id
                    WHERE a.status_aktif = 1 AND a.id_sekolah = $id_sekolah_
                    AND (a.siswa->'siswa' @> ANY (ARRAY ['[\"$siswa\"]']::jsonb[]) OR a.siswa->'siswa' @> ANY (ARRAY ['[$siswa]']::jsonb[])) ORDER BY a.hari,a.waktu_mulai ASC; ";

$data_jadwal = $dbSekolah->multipleRow($sql);
if (!empty($data_jadwal) || $data_jadwal != "") {
    $jadwal = array();
    foreach ($data_jadwal as $key => $value) {
        $jadwal[$value->hari][] = array(
            'tahun'         => $value->tahun,
            'semester'      => $value->semester,
            'waktu_mulai'   => $value->waktu_mulai,
            'waktu_selesai' => $value->waktu_selesai,
            'matpel'        => $value->nama_matpel,
            'guru'          => $value->nama_guru,
        );
    }
    $response = array(
        'response_code'    => '0000',
        'response_message' => 'Data Jadwal Per Siswa Di temukan',
        'detail'           => $jadwal,
    );
} else {
    $response = array(
        'response_code'    => '0404',
        'response_message' => 'Jadwal Tidak Di temukan',
    );
}
$reply = json_encode($response);
