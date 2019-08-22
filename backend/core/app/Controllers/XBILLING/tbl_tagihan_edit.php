<?php
$dbbi = new Models\DbBilling();

//M1 KEPALA DINAS, M2 KABAG, M3 PEGAWAI PENAMBAH TAGIHAN
$jenis_tagihan = strtoupper($jreq->detail->jenis_tagihan); //imb
$idtagihan = strtoupper(trim($jreq->detail->idtagihan));
$idtagihan_name = strtoupper($jreq->detail->idtagihan_name);
$jatuh_tempo = trim($jreq->detail->jatuh_tempo);
$tagihan = $jreq->detail->tagihan;
$admin = $jreq->detail->admin;
$total_tagihan = $tagihan + $admin;

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
    if ($jrespon->status == '0000') {
        $sql_update = "update tbl_nomor_va set keterangan='updated $idtagihan_name' where noid='$idtagihan';"
                . "update tbl_tagihan set noid='$noid',idtagihan_name='$idtagihan_name',jatuh_tempo='$jatuh_tempo',"
                . "tagihan=$tagihan,admin_bank=$admin,total_tagihan=$total_tagihan,jenis_tagihan='$jenis_tagihan',"
                . "open_payment=$open_payment where idtagihan = '$idtagihan' ;";
        $response = array(
            'response_code' => '0000',
            'response_message' => "Sukses Update data Tagihan $jenis_tagihan $idtagihan"
        );
    } else {
        $sql_update = "delete from tbl_nomor_va where id=$arr_insert->id;";
        $response = array(
            'response_code' => '0099',
            'response_message' => "Gagal Update data Tagihan, Terjadi Kesalahan Sistem"
        );
    }
    $dbbi->singleRow($sql_update);
} else {
    $error->tagihanTidakDitemukan($saldo_member);
}
$reply = json_encode($response);
