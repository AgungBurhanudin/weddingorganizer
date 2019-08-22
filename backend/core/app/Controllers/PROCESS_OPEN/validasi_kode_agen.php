<?php

$kode_agen = $jreq->kode_agen;

$arr = $db->singleRow("select id,noid,alias_act,setting_card from tbl_act_card where alias_act = '$kode_agen'");

if (!isset($arr->id)) {
    $response = array(
        'response_code' => '0123',
        'response_message' => "Kode Aktivasi $kode_agen tidak ditemukan."
    );
} else {

    $arr_cek = $db->cekNohpMember($nohp_email);

    if (isset($arr_cek->id)) {
        //belum terdaftar harus isi kode agen
        $response = array(
            'response_code' => '0123',
            'response_message' => "$nohp_email TELAH TERDAFTAR, Tidak dapat digunakan."
        );
    } else {
        $noid_act = $arr->noid;
        $sql_cek = "select * from tbl_member_account where noid = '$noid_act' and tipe = 'M2'";
        $arr_cek = $db->singleRow($sql_cek);

        if (isset($arr_cek->id)) {
            $noid_agen = $arr_cek->noid;
            $tipe_agen = $arr_cek->tipe;
            $key_validasi = $fungsi->randomNumber(4);

            $message = "$nama_aplikasi, KODE VALIDASI = $key_validasi . Rahasiakan kode validasi untuk keamanan transaksi. Kode dapat digunakan dalam 5 menit.";
            $sql = "BEGIN TRANSACTION;"
                    . "insert into log_validasi (noid,djson_validasi,kode_validasi,noid_agen,tipe_agen) values"
                    . "('$nohp_email','$param','$key_validasi','$noid_agen','$tipe_agen');"
                    . "COMMIT;";

            $db->singleRow($sql);
            $db->kirimMessageUnreg($nohp_email, $message);
            if (is_numeric($nohp_email) == TRUE) {
                $jenis_msg = 'NOHP';
            } else {
                $jenis_msg = 'EMAIL';
            }
            $response = array(
                'response_code' => '0000',
                'response_message' => 'Kode Validasi ' . $key_validasi . ' sedang dikirim ke ' . $jenis_msg . ' ' . $nohp_email . ' KODE DAPAT DIGUNAKAN DALAM 5 MENIT'
            );
        } else {
            //belum terdaftar harus isi kode agen
            $response = array(
                'response_code' => '0099',
                'response_message' => 'Kode Sekolah yang anda masukkan tidak terdaftar'
            );
        }
    }
}
$reply = json_encode($response);
