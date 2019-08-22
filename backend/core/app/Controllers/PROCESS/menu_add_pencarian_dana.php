<?php
$dbSekolah = new Models\DbSekolah();
$fungsi = new Libraries\Fungsi();
$noid = $jreq->noid;
$nominal = $jreq->nominal;

$cek_exist = $db->singleRow("SELECT * FROM tbl_cash_out WHERE noid = '$noid' AND status = '0'");
if(empty($cek_exist)){
    $no_tiket = $fungsi->randomNumber(6);
    $query = "INSERT INTO tbl_cash_out (no_tiket, noid, nominal, status, create_time) "
            . "VALUE ('$no_tiket', '$noid', '$nominal', '0', now()) RETURNING id ";
    $insert = $db->singleRow($query);
    if(isset($insert->id)){
        $response = array(
            'response_core' => '0000',
            'response_message' => 'Berhasil Menambah Request Pencairan Dana, No Tiket Anda #'.$no_tiket
        );
    }else{
        $response = array(
            'response_core' => '9999',
            'response_message' => 'Gagal Menambah Request Pencairan Dana'
        );
    }
}else{
    $response = array(
        'response_core' => '9999',
        'response_message' => 'Gagal Menambah Request Pencairan Dana, Anda belum menyelesaikan proses sebelumnya'
    );
}
$reply = json_encode($response);

