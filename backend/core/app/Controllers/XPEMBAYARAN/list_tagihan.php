<?php

$dbSekolah   = new Models\DbSekolah;
$noid        = $jreq->noid;
$data_member = $db->cekId('tbl_member_channel', 'noid', $noid);
$id_sekolah  = $data_member->kode_sekolah;
$id_siswa    = (isset($jreq->detail->id_siswa)) ? $jreq->detail->id_siswa : '';
$status      = (isset($jreq->detail->status)) ? $jreq->detail->status : '';

$sort = 'a.jatuh_tempo';

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

$sql = "SELECT a.id,b.nis,b.nama,a.jenis_tagihan,a.nama_tagihan,a.jatuh_tempo,a.tagihan,a.denda,a.total,a.keterangan, a.pembayaran, a.sisa_tagihan,a.status,a.tanggal 
		FROM tbl_tagihan a
		LEFT JOIN tbl_siswa b ON a.id_pel = b.id
		WHERE a.id_pel = $id_siswa
		ORDER BY $sort ;";

$data = $dbSekolah->multipleRow($sql);
$no   = 1; // add number
if (!empty($data)) {
    foreach ($data as $key => $value) {
        $data[$key]->no 			= $no++;
		$data[$key]->tagihan 		= (int) $value->tagihan;
		$data[$key]->denda 			= (int) $value->denda;
		$data[$key]->total 			= (int) $value->total;
		$data[$key]->sisa_tagihan 	= (int) $value->sisa_tagihan;
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
