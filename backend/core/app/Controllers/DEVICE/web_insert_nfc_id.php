<?php

$nfc_id = strtoupper($nfc_id); 
$sql_cek = "update log_emoney set stat = 2, target_alias = '$nfc_id' where noid = '$noid' and username = '$username' returning id";
$arr_cek = $db->singleRow($sql_cek);
if (isset($arr_cek->id)) {
    $response = '0000#Sukses Insert NFC ID '.$nfc_id;
} else {
    $error->dataCashOutTidakAda($nfc_id);
}


$reply = $response;
