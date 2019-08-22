<?php

$dbSekolah    = new Models\DbSekolah();
$kode_sekolah = isset($jreq->id_sekolah) ? $jreq->id_sekolah : 0;
$noid_agen    = "";
$tipe         = "";
$key_validasi = $fungsi->randomNumber(4);
$message      = "$nama_aplikasi, KODE VALIDASI = $key_validasi . Rahasiakan kode validasi untuk keamanan transaksi. Kode dapat digunakan dalam 5 menit.";
if (is_numeric($nohp_email) == true) {
    $jenis_msg = 'NOHP';
} else {
    $jenis_msg = 'EMAIL';
    $response  = array(
        'response_code'    => '8888',
        'response_message' => 'No Hp yang Anda masukan tidak valid',
    );
    die(json_encode($response));
}
//Cek No Hp apakah sudah terdaftar sebagai guru atau belum
$cek_nohp_guru = $dbSekolah->singleRow("SELECT * FROM tbl_guru WHERE nohp = '$nohp_email'");
if(!isset($cek_nohp_guru->id)){	
    $response  = array(
        'response_code'    => '9999',
        'response_message' => 'No Hp belum terdaftar sebagai No Hp Guru Sekolah',
    );
    die(json_encode($response));
}

if($cek_nohp_guru->is_registered == 1){

    $sql = "BEGIN TRANSACTION;"
        . "insert into log_validasi (noid,djson_validasi,kode_validasi, tipe_agen) values"
        . "('$nohp_email','$param','$key_validasi','GR');"
        . "COMMIT;";

    $db->singleRow($sql);
    $db->kirimMessageUnreg($nohp_email, $message);
		
    $response = array(
        'response_code'  => '1111',
        'response_message' => 'Kode Validasi ' . $key_validasi . ' sedang dikirim ke ' . $jenis_msg . ' ' . $nohp_email . ' KODE DAPAT DIGUNAKAN DALAM 5 MENIT',
        // 'id_sekolah' => $cek_nohp_guru->id_sekolah
    );
}else{

        $sql = "BEGIN TRANSACTION;"
            . "insert into log_validasi (noid,djson_validasi,kode_validasi, tipe_agen) values"
            . "('$nohp_email','$param','$key_validasi','GR');"
            . "COMMIT;";

        $db->singleRow($sql);
        $db->kirimMessageUnreg($nohp_email, $message);

        $response = array(
            'response_code'    => '0000',
            'response_message' => 'Kode Validasi ' . $key_validasi . ' sedang dikirim ke ' . $jenis_msg . ' ' . $nohp_email . ' KODE DAPAT DIGUNAKAN DALAM 5 MENIT',
        );
}
$reply = json_encode($response);
