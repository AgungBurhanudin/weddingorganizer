<?php
//edit nama email
$noid_add = strtoupper(trim($jreq->detail->noid));
$action_add = strtoupper(trim($jreq->detail->jenis));

if($action_add == 'BLOCK'){
    $stat = 0;
}elseif($action_add == 'UNBLOCK'){
    $stat = 1;
}else{
    $error->tipeActionTidakValid($saldo_member);
}

$arr = $db->cekNoidMemberNostat($noid_add);
if (isset($arr->id)) {
    $nama_add = $arr->nama;
    $jenis_add = $arr->jenis;
    $noid_ca_add = $arr->noid_mit;
    $noid_subca_add = $arr->noid_submit;
    
    $tipe_add = $arr->tipe;
    if($tipe_add == 'M1'){
        $kondisi = "noid_mit = '$noid_add'";
    }elseif($tipe_add == 'M2'){
        $kondisi = "noid_submit = '$noid_add'";
    }elseif($tipe_add == 'M3'){
        $error->tipeActionTidakValid($saldo_member);
    }else{
        $kondisi = "noid = '$noid_add'";
    }

    $aturan = $jenis_member . $jenis_add; //pegawai boleh edit semua nya, M1 edit downline, M2 edit downline, M3 edit diri sendiri
    if ($aturan == '21' || $noid == $noid_ca_add || $noid == $noid_subca_add) {
        
        $sql = "BEGIN TRANSACTION;"
                . "update tbl_member_account set status = $stat "
                . "where $kondisi;"
                . "COMMIT;";
        $db->singleRow($sql);

        $response = array(
            'response_code' => '0000',
            'response_message' => "$action_add MEMBER $nama_add DATA BERHASIL",
            'saldo' => $saldo_member
        );
    } else {
        $error->regAccountTidakBerhak($saldo_member);
    }
} else {
    $error->accountTidakAda($saldo_member);
}

$reply = json_encode($response);
