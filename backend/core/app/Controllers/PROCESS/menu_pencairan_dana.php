<?php
$dbSekolah = new Models\DbSekolah();
$noid = $jreq->noid;
//$nominal = $jreq->nominal;

$cek_exist = $db->multipleRow("SELECT * FROM tbl_cash_out WHERE noid = '$noid' ORDER BY create_time DESC");
if(!empty($cek_exist)){
    $response = array(
        'response_code' => '0000',
        'response_message' => 'Data Di temukan',
        'detail' => $cek_exist
    );
}else{
    $response = array(
        'response_code' => '9999',
        'response_message' => 'Data Tidak Di temukan'
    );
}
$reply = json_encode($response);

