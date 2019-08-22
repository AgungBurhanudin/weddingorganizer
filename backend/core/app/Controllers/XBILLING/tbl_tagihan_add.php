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

$arr_cek = $dbbi->cekIdTagihan($idtagihan);

if (!isset($arr_cek->id)) {
    //tembak service va
    $sql_insert = "insert into tbl_nomor_va (noid,bank,keterangan,jenis) values "
            . "('$idtagihan','BNIS','insert',1) returning id";
    $arr_insert = $dbbi->singleRow($sql_insert);
    $id_va = str_pad($arr_insert->id, 12, "0", STR_PAD_LEFT);
    $email = '';
    if ($tagihan == 0) {
        $url = "http://dsyariah.co.id/tki/va/create_open_va.php";
        $open_payment = 1;
    } else {
        $url = "http://dsyariah.co.id/tki/va/create_close_va.php";
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
        $sql_update = "update tbl_nomor_va set nomor_va='$jrespon->virtual_account',keterangan='$idtagihan_name' where id=$arr_insert->id;"
                . "insert into tbl_tagihan(noid,idtagihan,idtagihan_name,jatuh_tempo,tagihan,admin_bank,total_tagihan,jenis_tagihan,open_payment) "
                . "values ('$noid','$idtagihan','$idtagihan_name','$jatuh_tempo',$tagihan,$admin,$total_tagihan,'$jenis_tagihan',$open_payment)";
        $response = array(
            'response_code' => '0000',
            'response_message' => "Sukses Input data Tagihan $jenis_tagihan $idtagihan dengan Nomor VA $jrespon->virtual_account"
        );
    } else {
        $sql_update = "delete from tbl_nomor_va where id=$arr_insert->id;";
        $response = array(
            'response_code' => '0099',
            'response_message' => "Gagal Input data Tagihan, Terjadi Kesalahan Sistem"
        );
    }
    $dbbi->singleRow($sql_update);
} else {
    $error->regIdTagihanTerdaftar($saldo_member);
}
$reply = json_encode($response);
