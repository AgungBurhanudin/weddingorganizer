<?php

$action = $jreq->detail->action;

if ($action == 'CHECK') {
    $arr = $db->cekNoidMember($noid);
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
} elseif ($action == 'UPDATE') {
    $noid_add = $noid;
    $nama_add = strtoupper(trim($jreq->detail->nama));
    $nik_add = strtoupper(trim($jreq->detail->nik));
    $tgl_lahir_add = strtoupper(trim($jreq->detail->tgl_lahir));
    $alamat_add = strtoupper(trim($jreq->detail->alamat));
    $provinsi = strtoupper($jreq->detail->provinsi);
    $provinsi_value = strtoupper($jreq->detail->provinsi_value);
    $kota_kabupaten = strtoupper($jreq->detail->kota_kabupaten);
    $kota_kabupaten_value = strtoupper($jreq->detail->kota_kabupaten_value);
    $kecamatan = strtoupper($jreq->detail->kecamatan);
    $kecamatan_value = strtoupper($jreq->detail->kecamatan_value);
    $kelurahan = strtoupper($jreq->detail->kelurahan);
    $kelurahan_value = strtoupper($jreq->detail->kelurahan_value);
    $rt = strtoupper($jreq->detail->rt);
    $rw = strtoupper($jreq->detail->rw);
    $kodepos = strtoupper($jreq->detail->kodepos);

    $arr = $db->cekNoidMember($noid_add);
    if (isset($arr->id)) {
        $jenis_add = $arr->jenis;
        $noid_ca_add = $arr->noid_mit;
        $noid_subca_add = $arr->noid_submit;

        $sql = "BEGIN TRANSACTION;"
                . "update tbl_member_account set nama = '$nama_add', alamat = '$alamat_add', nik = '$nik_add', "
                . "tgl_lahir = '$tgl_lahir_add', provinsi = '$provinsi', kota_kabupaten = '$kota_kabupaten', "
                . "kecamatan = '$kecamatan', kelurahan = '$kelurahan', provinsi_value = '$provinsi_value', kota_kabupaten_value = '$kota_kabupaten_value', "
                . "kecamatan_value = '$kecamatan_value', kelurahan_value = '$kelurahan_value', rt = '$rt', rw = '$rw', kodepos = '$kodepos' "
                . "where noid = '$noid_add';"
                . "COMMIT;";
        $db->singleRow($sql);

        $response = array(
            'response_code' => '0000',
            'response_message' => 'UPDATE DATA BERHASIL',
            'saldo' => $saldo_member
        );
    } else {
        $error->accountTidakAda($saldo_member);
    }

    $reply = json_encode($response);
} else {
    $error->tipeActionTidakValid($saldo_member);
}