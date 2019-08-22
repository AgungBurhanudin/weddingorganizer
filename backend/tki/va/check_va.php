<?php
ini_set('display_errors', 0);

include "resources/setting/Path.inc.php";

try {
    require_once "$_PATH/resources/util/BniEnc.php";
    
    $param = file_get_contents('php://input');
    $jreq = json_decode($param);
        
    $noid = $jreq->noid;
    $bank = "BNIS";
            
    if ($bank == "BNIS") {
        $expired  = date('c', mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+100));
        
        $data_asli = array(
                'client_id' => $client_id,
                'trx_id' => $noid,
                'type' => 'inquirybilling'
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
            echo $response;
            $data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
            
            $reply = $data_response;
        }
    }
} catch (Exception $ex) {
    $response = array(
        'status' => '0005',
        'message' => $ex->getMessage()
    );
    $tiketDepositDao->update($idTiketDeposit, "error", $nominal);
    $reply = json_encode($response);
}

echo urldecode(stripslashes($reply));