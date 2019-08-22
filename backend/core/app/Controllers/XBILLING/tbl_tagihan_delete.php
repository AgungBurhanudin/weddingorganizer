<?php
$dbbi = new Models\DbBilling();

//M1 KEPALA DINAS, M2 KABAG, M3 PEGAWAI PENAMBAH TAGIHAN
$jenis_tagihan = 'DELETE'; //imb
$idtagihan = trim($jreq->detail->idtagihan);
$idtagihan_name = 'DELETE';
$tagihan = 0;
$admin = 0;
$total_tagihan = 0;

$arr_cek = $dbbi->cekIdTagihanVa($idtagihan);

if (isset($arr_cek->id)) {

    $id_va = $arr_cek->nomor_va;
    $email = '';
    if ($arr_cek->tagihan == 0) {
        $url = "http://dsyariah.co.id/tki/va/update_open_va.php";
        $open_payment = 1;
    } else {
        $url = "http://dsyariah.co.id/tki/va/update_close_va.php";
        $open_payment = 0;
    }

    $request = '{"noid": "' . $idtagihan . '",'
            . '"nohp": "' . $id_va . '",'
            . '"nama": "' . $idtagihan_name . '",'
            . '"email": "' . $email . '",'
            . '"nominal":' . $total_tagihan . '}';

//    $contents = $this->rest->sendRequest($url, 'POST', $request);
    $contents = '{"status": "0000",'
            . '"virtual_account": "VA' . $id_va . '"}';
    $jrespon = json_decode($contents);

    $sql_update = "update tbl_nomor_va set keterangan='updated $idtagihan_name' where noid='$idtagihan';"
            . "update tbl_tagihan set noid='$noid',idtagihan_name='$idtagihan_name',"
            . "tagihan=$tagihan,admin_bank=$admin,total_tagihan=$total_tagihan,jenis_tagihan='$jenis_tagihan',"
            . "open_payment=$open_payment where idtagihan = '$idtagihan' ;";
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Hapus ID Tagihan $idtagihan"
    );

    $dbbi->singleRow($sql_update);
} else {
    $error->tagihanTidakDitemukan($saldo_member);
}
$reply = json_encode($response);
