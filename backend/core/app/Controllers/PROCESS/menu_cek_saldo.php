<?php

$arr_member = $db->cekNoidMember($noid);
if (isset($arr_member->saldo)) {
    $saldo = $arr_member->saldo;
    $response = array(
        'response_code' => '0000',
        'response_message' => 'Nomor ID anda : ' . $noid . '. Saldo Anda Rp. ' . $fungsi->rupiah($saldo),
        'saldo' => $fungsi->rupiah($saldo)
    );
} else {
    $error->accountTidakAda($saldo_member);
}


$reply = json_encode($response);
