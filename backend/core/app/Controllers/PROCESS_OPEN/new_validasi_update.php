<?php
$dbSekolah = new Models\DbSekolah();
    $jenis       = 'MEMBER';
    $saldo_member = 0;
    $jenis_tbl    = 1;
    $prefix_ca    = '0';
    $prefix_subca = '0';
    $noid_ca      = '0';
    $noid_subca   = '0';
    $tipe_message = 'SMS';

//if mobile kirim password yang akan digunakan
$token_aktivasi   = strtoupper($jreq->token_aktivasi);
$arr_cek_validasi = $db->singleRow("SELECT id,noid_agen,tipe_agen FROM log_validasi WHERE noid = '$nohp_email' "
    . "and kode_validasi = '$token_aktivasi' and status = 9 and date(waktu) = date(now()) order by id desc limit 1");

$noid_add = "";
if ($arr_cek_validasi != false) {
    $noid        = $arr_cek_validasi->noid_agen;
    if(empty($noid) ||  $noid == ""){        
        $arr_act_card = $db->cekId('tbl_act_card', 'alias_act', $id_sekolah);
        $noid         = $arr_act_card->noid;
    }
    $awal_noid   = substr($noid, 0, 7);
    $tipe_member = "M2";

    $nama_add             = strtoupper(trim($jreq->detail->nama_ortu));
    $nik_add              = isset($jreq->detail->nik) ? strtoupper(trim($jreq->detail->nik)) : "";
    $tgl_lahir_add        = isset($jreq->detail->tgl_lahir) ? strtoupper(trim($jreq->detail->tgl_lahir)) : "";
    $alamat_add           = isset($jreq->detail->alamat) ? strtoupper(trim($jreq->detail->alamat)) : "";
    $provinsi             = isset($jreq->detail->provinsi) ? strtoupper($jreq->detail->provinsi) : "";
    $provinsi_value       = isset($jreq->detail->provinsi_value) ? strtoupper($jreq->detail->provinsi_value) : "";
    $kota_kabupaten       = isset($jreq->detail->kota_kabupaten) ? strtoupper($jreq->detail->kota_kabupaten) : "";
    $kota_kabupaten_value = isset($jreq->detail->kota_kabupaten_value) ? strtoupper($jreq->detail->kota_kabupaten_value) : "";
    $kecamatan            = isset($jreq->detail->kecamatan) ? strtoupper($jreq->detail->kecamatan) : "";
    $kecamatan_value      = isset($jreq->detail->kecamatan_value) ? strtoupper($jreq->detail->kecamatan_value) : "";
    $kelurahan            = isset($jreq->detail->kelurahan) ? strtoupper($jreq->detail->kelurahan) : "";
    $kelurahan_value      = isset($jreq->detail->kelurahan_value) ? strtoupper($jreq->detail->kelurahan_value) : "";
    $email                = isset($jreq->detail->email) ? $jreq->detail->email : "";
    $id_sekolah           = $jreq->detail->id_sekolah;

    $rt      = isset($jreq->detail->rt) ? strtoupper($jreq->detail->rt) : "";
    $rw      = isset($jreq->detail->rw) ? strtoupper($jreq->detail->rw) : "";
    $kodepos = isset($jreq->detail->kodepos) ? strtoupper($jreq->detail->kodepos) : "";

}else{
    $response = array(
        'response_code'    => '0091',
        'response_message' => 'KODE VALIDASI yang anda masukkan salah atau sudah berbeda tanggal',
    );
}
$reply = json_encode($response);