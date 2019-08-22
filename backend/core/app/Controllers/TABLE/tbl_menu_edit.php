<?php

$id_add = strtoupper(trim($jreq->detail->id));
$perintah = $jreq->detail->perintah;
$hak_akses = $jreq->detail->hak_akses;
$aturan = json_encode($jreq->detail->aturan);
$validasi = $jreq->detail->validasi;
$status = $jreq->detail->status;
$keterangan = $jreq->detail->keterangan;

$arr_cek = $db->cekId('tbl_menu','id',$id_add);

if (isset($arr_cek->id)) {
    $_perintah = $arr_cek->perintah;
    $sql = "BEGIN TRANSACTION;"
            . "update tbl_menu set perintah='$perintah', hak_akses='$hak_akses',aturan ='$aturan',"
			. "validasi ='$validasi',status='$status', keterangan='$keterangan' where id = $id_add;"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Update Menu $perintah",
        'saldo' => $saldo_member
    );
} else {
    $error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

