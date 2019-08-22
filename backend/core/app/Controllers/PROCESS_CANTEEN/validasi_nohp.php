<?php
$dbSekolah = new Models\DbSekolah;
$query_cek = "SELECT * FROM tbl_canteen WHERE nohp_pemilik = '$nohp_email'";
    if (is_numeric($nohp_email) == TRUE) {
        $jenis_msg = 'NOHP';
    } else {
        $jenis_msg = 'EMAIL';
    }
$arr_cek = $db->cekNohpMemberReg($nohp_email);
$arr_cek2= $dbSekolah->singleRow($query_cek);
if(!empty($arr_cek)){
//$password = $jreq->password;
    if (isset($arr_cek->id)) {
        if ($arr_cek->tipe != 'M3') {
            $response = array(
                'response_code' => '0123',
                'response_message' => $jenis_msg. ' Anda tidak dapat digunakan untuk transaksi Mobile karena sudah terdaftar.'
            );
            die(json_encode($response));
        }
        //sudah terdaftar
        $key_validasi = $fungsi->randomNumber(4);

        $message = "$nama_aplikasi, KODE VALIDASI = $key_validasi . Rahasiakan kode validasi untuk keamanan transaksi. Kode dapat digunakan dalam 5 menit.";
        $sql = "BEGIN TRANSACTION;"
                . "insert into log_validasi (noid,djson_validasi,kode_validasi) values"
                . "('$nohp_email','$param','$key_validasi');"
                . "COMMIT;";

        $db->singleRow($sql);
        $db->kirimMessageUnreg($nohp_email, $message);

        $response = array(
            'response_code' => '0000',
            'response_message' => 'Kode Validasi ' . $key_validasi . ' sedang dikirim ke ' . $jenis_msg . ' ' . $nohp_email . ' KODE DAPAT DIGUNAKAN DALAM 5 MENIT'
        );
    } else {
        //belum terdaftar harus isi kode agen
        $response = array(
            'response_code' => '0123',
            'response_message' => $jenis_msg . ' anda belum terdaftar, Masukkan Kode Agen untuk pendaftaran.'
        );
    }
}else if(!empty($arr_cek2)){
        //sudah terdaftar di tbl canteen
        $id_sekolah = $arr_cek2->id_sekolah;
        $arr_sekolah= $dbSekolah->cekId('tbl_sekolah','id', $id_sekolah);
        $kode_sekolah = $arr_sekolah->kode_sekolah;

        $arr_act_card = $db->cekId('tbl_act_card','alias_act',$kode_sekolah);
        $noid_agen    = $arr_act_card->noid;
        $key_validasi = $fungsi->randomNumber(4);


        $message = "$nama_aplikasi, KODE VALIDASI = $key_validasi . Rahasiakan kode validasi untuk keamanan transaksi. Kode dapat digunakan dalam 5 menit.";
        $sql = "BEGIN TRANSACTION;"
                . "insert into log_validasi (noid,djson_validasi,kode_validasi,noid_agen,tipe_agen) values"
                . "('$nohp_email','$param','$key_validasi', '$noid_agen', 'M2');"
                . "COMMIT;";

        $db->singleRow($sql);
        $db->kirimMessageUnreg($nohp_email, $message);

        $response = array(
            'response_code' => '0000',
            'response_message' => 'Kode Validasi ' . $key_validasi . ' sedang dikirim ke ' . $jenis_msg . ' ' . $nohp_email . ' KODE DAPAT DIGUNAKAN DALAM 5 MENIT'
        );
}else{    
    $response = array(
        'response_code' => '0123',
        'response_message' => $jenis_msg . ' anda belum terdaftar.'
    );
}

$reply = json_encode($response);
