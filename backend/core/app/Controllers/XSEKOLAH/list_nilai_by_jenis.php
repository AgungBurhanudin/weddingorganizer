<?php

$dbSekolah   = new Models\DbSekolah;
$fungsi      = new Libraries\Fungsi();
$nohp        = $jreq->nohp;
$arr_guru    = $dbSekolah->cekId('tbl_guru', 'nohp', $nohp);
$id_sekolah  = $arr_guru->id_sekolah; //$jreq->id_sekolah;
$id_guru     = $arr_guru->id;
$jenis_nilai = $jreq->jenis_nilai;
$data        = array();
$sql         = "SELECT a.*,b.nis,b.nama FROM tbl_nilai
                LEFT JOIN tbl_siswa b on a.id_siswa =  b.id
                WHERE id_guru = $id_guru AND jenis_nilai = '$jenis_nilai'";
$data_nilai = $dbSekolah->multipleRow($sql);
$no         = 1;
foreach ($data_nilai as $key => $value) {
    $data[$key]->no          = $no++;
    $data[$key]->jenis_nilai = $jenis_nilai;
    $data[$key]->id          = $value->id;
    $data[$key]->nis         = $value->nis;
    $data[$key]->nama        = $value->nama;
    $data[$key]->matpel      = $value->matpel;
    $data[$key]->nilai       = (int) $value->nilai;
}
if (!empty($data)) {
    $response = array(
        'response_code'    => '0000',
        'response_message' => 'Data Ditemukan',
        'detail'           => $detail,
    );
} else {
    $response = array(
        'response_code'    => '9999',
        'response_message' => 'Data Tidak Di temukan',
    );
}
$reply = json_encode($response);
