<?php

$id_add = strtoupper(trim($jreq->detail->id));
$nama_add = strtoupper(trim($jreq->detail->nama));
$alamat_add = strtoupper(trim($jreq->detail->alamat));

$arr = $db->cekGroupKolektif($noid,$nama_add);

if (isset($arr->id)) {
    $error->namaKolektifTerdaftar($saldo_member);
}

$arr_cek = $db->singleRow("select id,nama from tbl_group_kolektif where id = $id_add");

if (isset($arr_cek->id)) {
    $nama = $arr_cek->nama;
    $sql = "BEGIN TRANSACTION;"
            . "update tbl_group_kolektif set nama='$nama_add', alamat='$alamat_add' where id = $id_add;"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Update Group Kolektif $nama menjadi $nama_add",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

