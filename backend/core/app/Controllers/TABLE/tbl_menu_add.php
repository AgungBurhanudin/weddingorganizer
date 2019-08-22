<?php


$perintah = $jreq->detail->perintah;
$hak_akses = $jreq->detail->hak_akses;
$aturan = json_encode($jreq->detail->aturan);
$validasi = $jreq->detail->validasi;
$status = $jreq->detail->status;
$keterangan = $jreq->detail->keterangan;

$arr_cek = $db->cekId('tbl_menu','perintah',$perintah);

if (!isset($arr_cek->id)) {
    $sql = "BEGIN TRANSACTION;"
            . "insert into tbl_menu (perintah, hak_akses, aturan, validasi, status, keterangan) values"
            . "('$perintah','$hak_akses','$aturan','$validasi','$status','$keterangan');"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Penambahan Menu $perintah",
        'saldo' => $saldo_member
    );
} else {
    $error->menuTerdaftar($perintah);
}
$reply = json_encode($response);
