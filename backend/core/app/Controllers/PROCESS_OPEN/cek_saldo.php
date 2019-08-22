<?php

$dbSekolah = new Models\DbSekolah;
$nfc_id = $nohp_email;
$noid = isset($jreq->noid) ? $jreq->noid : "";
$saldo_member = 0;

// $response = array(
//     'response_code' => '0000',
//     'response_message' => 'Nomor ID anda : ' . $nfc_id . '. Saldo Anda Rp. '
// );
// $reply = json_encode($response);
// die();
if (!empty($nfc_id)) {
    $arr_member = $db->singleRow("SELECT noid,nis,kode_sekolah,limit_trx FROM tbl_member_channel WHERE alias = '$nfc_id' AND interface = 'NFC'");
    if (isset($arr_member->noid)) {
        $noid = $arr_member->noid;
        $nis = $arr_member->nis;
        $limit_trx = $arr_member->limit_trx;
        $arr_siswa = $dbSekolah->cekId('tbl_siswa', 'nis', $nis);
        $nama_siswa = "";
        if (isset($arr_siswa->id)) {
            $nama_siswa = $arr_siswa->nama;
        }
        $arr_member_account = $db->cekNoidMember($noid);
        if (isset($arr_member_account->saldo)) {
            $saldo = $arr_member_account->saldo;
            $response = array(
                'response_code' => '0000',
                'response_message' => 'Nomor ID anda : ' . $noid . '. Saldo Anda Rp. ' . $fungsi->rupiah($saldo),
                'saldo' => (int) $saldo,
                'nis' => $nis,
                'nama' => $nama_siswa,
                'nfc_id' => $nfc_id,
                'sisa_limit' => $limit_trx
            );
            $reply = json_encode($response);
        } else {
            $error->accountTidakAda($saldo_member);
        }
    } else {
        $error->accountTidakAda($saldo_member);
    }
} else if (!empty($noid) || $noid != "") {
    $arr_member_account = $db->cekNoidMember($noid);
    if (isset($arr_member_account->saldo)) {
        $saldo = $arr_member_account->saldo;
        $response = array(
            'response_code' => '0000',
            'response_message' => 'Nomor ID anda : ' . $noid . '. Saldo Anda Rp. ' . $fungsi->rupiah($saldo),
            'saldo' => (int) $saldo
        );
        $reply = json_encode($response);
    } else {
        $error->accountTidakAda($saldo_member);
    }
}