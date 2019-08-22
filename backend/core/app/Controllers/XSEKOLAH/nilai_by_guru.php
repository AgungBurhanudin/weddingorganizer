<?php

$dbSekolah  = new Models\DbSekolah;
$fungsi     = new Libraries\Fungsi();
$nohp       = $jreq->nohp;
$arr_guru   = $dbSekolah->cekId('tbl_guru', 'nohp', $nohp);
$id_sekolah = $arr_guru->id_sekolah; //$jreq->id_sekolah;
$id_guru    = $arr_guru->id;

$sql  = "SELECT jenis_nilai FROM tbl_nilai WHERE id_guru = $id_guru GROUP BY jenis_nilai";
$data = $dbSekolah->multipleRow($sql);

if (isset($query->id)) {
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
