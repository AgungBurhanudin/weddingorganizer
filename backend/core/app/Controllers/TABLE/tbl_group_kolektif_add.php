<?php

$nama_add = strtoupper(trim($jreq->detail->nama));
$jenis_add = strtoupper(trim($jreq->detail->jenis));
$alamat_add = strtoupper(trim($jreq->detail->alamat));

$arr_cek = $db->cekGroupKolektif($noid,$nama_add);

if (!isset($arr_cek->id)) {
    $sql = "BEGIN TRANSACTION;"
            . "insert into tbl_group_kolektif (noid,nama,jenis,alamat) values"
            . "('$noid','$nama_add','$jenis_add','$alamat_add');"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Penambahan Group Kolektif $nama_add $jenis_add",
        'saldo' => $saldo_member
    );
} else {
    $error->namaKolektifTerdaftar($saldo_member);
}
$reply = json_encode($response);
