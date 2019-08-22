<?php

$sql_delete = "delete from log_message where noid = '$noid' and stat = 1;";
$db->singleRow($sql_delete);
$response = array(
    'response_code' => '0000',
    'response_message' => "Hapus Seluruh Pesan Berhasil.",
    'saldo' => $saldo_member
);

$reply = json_encode($response);
