<?php

$dest_add = strtoupper($jreq->detail->noid);
$arr = $db->cekNoidMember($dest_add);
if (isset($arr->id)) {
    $response = array(
        'response_code' => '0000',
        'response_message' => 'CEK DATA MEMBER BERHASIL',
        'nama' => $arr->nama,
        'nik' => $arr->nik,
        'tgl_lahir' => $arr->tgl_lahir,
        'nohp_email' => $arr->nohp_email,
        'alamat' => $arr->alamat,
        'provinsi' => $arr->provinsi,
        'provinsi_value' => $arr->provinsi_value,
        'kota_kabupaten' => $arr->kota_kabupaten,
        'kota_kabupaten_value' => $arr->kota_kabupaten_value,
        'kecamatan' => $arr->kecamatan,
        'kecamatan_value' => $arr->kecamatan_value,
        'kelurahan' => $arr->kelurahan,
        'kelurahan_value' => $arr->kelurahan_value,
        'rt' => $arr->rt,
        'rw' => $arr->rw,
        'kodepos' => $arr->kodepos
    );
} else {
    $error->accountTidakAda($saldo_member);
}

$reply = json_encode($response);
