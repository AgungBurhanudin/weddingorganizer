<?php

$alias_add = strtoupper(trim($jreq->detail->alias));
$arr = $db->cekAliasChannel($alias_add);
if (isset($arr->id)) {
    $noid_add = $arr->noid;
    if($arr->interface == 'MOBILE'){
        if (($noid_add == $noid) || (substr($noid_add,0,7) == substr($noid,0,7) && $tipe_member == 'M2')) {
    
        } else {
            $error->globalTidakBerhak($saldo_member);
        }
    }
    
    if ($jenis_member == '2' || $noid_add == $noid || $arr->interface == 'MOBILE') {
        $sql = "BEGIN TRANSACTION;"
                . "delete from tbl_member_channel where id = $arr->id;"
                . "COMMIT;";
        $db->singleRow($sql);
        $msg_out = "Channel $interface $arr->alias a.n $arr->nama TELAH DIHAPUS";
        $db->kirimMessage($noid_add,$msg_out);
        $response = array(
            'response_code' => '0000',
            'response_message' => 'DELETE DATA BERHASIL',
            'saldo' => $saldo_member
        );
    } else {
        $error->globalTidakBerhak($saldo_member);
    }
} else {
    $error->channelTidakAda($saldo_member);
}
$reply = json_encode($response);
