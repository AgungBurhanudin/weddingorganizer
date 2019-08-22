<?php

$dbSekolah = new Models\DbSekolah();

$noid       = $jreq->noid;
$id_sekolah = isset($jreq->detail->id_sekolah) ? $jreq->detail->id_sekolah : "";

if (empty($id_sekolah) || $id_sekolah == "") {
    $cek_account_m2 = $db->singleRow("SELECT * FROM tbl_member_account WHERE noid='$noid'");
    $noid_m2        = $cek_account_m2->noid_act;
    $cek_channel    = $db->singleRow("SELECT * FROM tbl_member_channel WHERE noid='$noid_m2' AND interface = 'WEB'");
    $id_sekolah     = $cek_channel->kode_sekolah;
}

if (empty($noid)) {
    $response = array(
        'response_code'    => '0099',
        'response_message' => 'Kesalahan Sistem, Data Ortu Kosong',
    );
    die(json_encode($response));
}

$query_cek_siswa = "SELECT kode_sekolah, nis FROM tbl_member_channel WHERE noid = '$noid' AND interface = 'NFC' AND kode_sekolah = '$id_sekolah'";

$data_siswa = $db->multipleRow($query_cek_siswa);

$arr_member_account = $db->cekId('tbl_member_account', 'noid', $noid);
$arr_sekolah        = $dbSekolah->cekId('tbl_sekolah', 'kode_sekolah', $id_sekolah);
$nohp               = $arr_member_account->nohp_email;
$id_school          = $arr_sekolah->id;
$query_cek_siswa2   = "SELECT * FROM tbl_siswa WHERE nohp_wali = '$nohp' AND id_sekolah = '$id_school'";
$data_siswa2        = $dbSekolah->multipleRow($query_cek_siswa2);

if (!empty($data_siswa)) {
    $detail_siswa = array();
    foreach ($data_siswa as $k => $v) {
        $nis            = $v->nis;
        $arr_siswa      = $dbSekolah->cekId('tbl_siswa', 'nis', $nis);
        $detail_siswa[] = array(
            'nis'           => $arr_siswa->nis,
            'nama'          => $arr_siswa->nama,
            'tanggal_lahir' => $arr_siswa->tanggal_lahir,
        );
    }
    $j_data_siswa = json_encode($detail_siswa);
    $response     = '{"response_code":"0000","response_message" : "Data Di temukan","detail" : ' . $j_data_siswa . '}';

} else if (!empty($data_siswa2)) {
    $detail_siswa = array();
    foreach ($data_siswa2 as $k => $v) {
        $detail_siswa[] = array(
            'nis'           => $v->nis,
            'nama'          => $v->nama,
            'tanggal_lahir' => $v->tanggal_lahir,
        );
    }
    $j_data_siswa = json_encode($detail_siswa);
    $response     = '{"response_code":"0000","response_message" : "Data Di temukan","detail" : ' . $j_data_siswa . '}';

} else {
    $response = '{"response_code":"0099","response_message" : "Data Tidak Di temukan"}';
}

$reply = $response;
