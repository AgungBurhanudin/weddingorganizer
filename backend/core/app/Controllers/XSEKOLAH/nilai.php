<?php

$fungsi       = new Libraries\fungsi;
$dbSekolah    = new Models\DbSekolah();
$table        = "tbl_nilai";
$noid         = $jreq->noid;
$data_member  = $db->cekId('tbl_member_channel', 'noid', $noid);
$kode_sekolah = $data_member->kode_sekolah;
$arrSekolah   = $db->cekId('tbl_sekolah', 'kode_sekolah', $kode_sekolah);
$id_sekolah   = $arrSekolah->id;

$jenis = isset($jreq->detail->jenis_nilai) ? $jreq->detail->jenis_nilai : "";
if ($jenis != "") {

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
            'response_code'    => '0000',
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

    $sql = "SELECT a.*,b.nis,b.nama FROM tbl_nilai a
            		LEFT JOIN tbl_siswa b on a.id_siswa = b.id
            		WHERE a.id_siswa = $id_siswa AND a.id_sekolah = $id_sekolah AND a.jenis_nilai = '$jenis_nilai' ;";

    $data = $dbSekolah->multipleRow($sql);
    $no   = 1; // add number
    if (!empty($data)) {
        foreach ($data as $key => $value) {
            $data[$key]->no     = $no++;
            $data[$key]->id     = $value->id;
            $data[$key]->nis    = $value->nis;
            $data[$key]->nama   = $value->nama;
            $data[$key]->matpel = $value->matpel;
            $data[$key]->nilai  = (int) $value->nilai;
        }

        $response = array(
            'response_code'    => '0000',
            'response_message' => 'Data Di temukan',
            'detail'           => $data,
        );
    } else {
        $response = array(
            'response_code'    => '0000',
            'response_message' => 'Data Tidak Di Temukan',
            'detail'           => "",
        );
        die(json_encode($response));
    }
    $reply = json_encode($response);
}
