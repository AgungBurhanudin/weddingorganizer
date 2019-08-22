<?php
ini_set('display_errors', 0);

include "resources/setting/Path.inc.php";

try {
    require_once "$_PATH/resources/util/BniEnc.php";
    
    $param = file_get_contents('php://input');
    BniEnc::writeLog("create_fix_va", "Request : " . $param);
    $jreq = json_decode($param);
    
    $noid = trim($jreq->noid);
    $nohp = "000000000000".trim($jreq->nohp);
    $nama = trim($jreq->nama);
    $email = trim($jreq->email);
    $bank = "BNI"; 
    $nominal = trim($jreq->nominal);
    
//    $memberVA = "988". $client_id . substr($nohp, -8); //prefix 988 untuk development
    $memberVA = "8". $client_id . substr($nohp, -12); //prefix 8 untuk production
    
    $expired  = date('c', mktime(0, 0, 0, date("m") + 1,   date("d"),   date("Y")));

    $data_asli = array(
            'client_id' => $client_id,
            'trx_id' => $noid,
            'trx_amount' => $nominal,
            'billing_type' => 'c',
            'datetime_expired' => $expired,
            'virtual_account' => $memberVA,
            'customer_name' => $nama,
            'customer_email' => $email,
            'customer_phone' => $nohp,
            'description' => 'VA '.$noid,
            'type' => 'createbilling'
    );
    
    $hashed_string = BniEnc::encrypt(
            $data_asli,
            $client_id,
            $secret_key
    );

    $data = array(
        'client_id' => $client_id,
        'data' => $hashed_string,
    );

    $response = BniEnc::get_content($urlBNI, json_encode($data));
    $response_json = json_decode($response, true);

    if ($response_json['status'] !== '000') {
        $reply = $response;
    } else {
        $data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
        $response = array(
            'status' => '0000',
            'bank' => $bank,
            'virtual_account' => $memberVA
        );

        $reply = json_encode($response);
    }
} catch (Exception $ex) {
    $response = array(
        'status' => '0005',
        'message' => $ex->getMessage()
    );
    $reply = json_encode($response);
}

BniEnc::writeLog("create_fix_va", "Reply : " . $reply);
echo urldecode(stripslashes($reply));
