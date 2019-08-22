<?php

$dbva = new Models\DbVa();
$dbSekolah = new Models\DbSekolah();
$fungsi = new Libraries\Fungsi();

$cek_flexible = $db->cekId('tbl_member_account', 'noid', '$noid');
$is_flexible  = isset($cek_flexible->is_flexible) ? $cek_flexible->is_flexible : "";

if($is_flexible == 0){	
	$sql_cek_nfc = "select bank,nomor_va,keterangan,status from tbl_nomor_va_bnis "
	        . "where noid = '$noid';";
	$arr_cek = $dbva->multipleRow($sql_cek_nfc);

}else{
	$sql_cek_va = "SELECT * FROM tbl_member_channel where noid = '$noid' AND interface = 'NFC'";
	$arr_cek    = $db->multipleRow($sql_cek_va);
	foreach ($arr_cek as $key => $value) {
		$nis = $value->nis;
		$kode_sekolah = $value->kode_sekolah;
		$arr_siswa = $dbSekolah->singleRow("SELECT a.nama,b.bank_va1 FROM tbl_siswa a LEFT JOIN tbl_sekolah b ON a.id_sekolah = b.id WHERE a.nis = '$nis' AND b.kode_sekolah = '$kode_sekolah'");
		$arr_cek[$key]->bank = isset($arr_siswa->bank_va1) ? $arr_siswa->bank_va1 : "";
		$arr_cek[$key]->nomor_va = $value->va_1;
		$arr_cek[$key]->keterangan = isset($arr_siswa->nama) ? $arr_siswa->nama : "";
		$arr_cek[$key]->status = "1";
	}
}

$response['response_code'] = '0000';
$response['response_message'] = 'OK';
$response['data'] = $arr_cek;
$reply = json_encode($response);
