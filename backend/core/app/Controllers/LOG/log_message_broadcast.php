<?php

$message_add = strtoupper($jreq->detail->message);

switch ($tipe_member) {
    case 'M1':
        $sql = "insert into log_message(waktu,noid,nohp_email,interface,msg,reff,stat,m1) values "
                . "(now(),'$noid','$noid','BROADCAST','$message_add','$ref',1,'$noid')";
        break;
    case 'M2':
        $sql = "insert into log_message(waktu,noid,nohp_email,interface,msg,reff,stat,m2) values "
                . "(now(),'$noid','$noid','BROADCAST','$message_add','$ref',1,'$noid')";
        break;
    case 'M3':
        $error->globalTidakBerhak($saldo_member);
        break;
    default :
        $sql = "insert into log_message(waktu,noid,nohp_email,interface,msg,reff,stat,pusat) values "
                . "(now(),'$noid','$noid','BROADCAST','$message_add','$ref',1,1)";
        break;
}

$db->singleRow($sql);
$response = array(
    'response_code' => '0000',
    'response_message' => "Broadcast pesan berhasil",
    'saldo' => $saldo_member
);
$reply = json_encode($response);
