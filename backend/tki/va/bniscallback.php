<?php
ini_set('display_errors', 0);

include "resources/setting/Path.inc.php";

try {
    require_once "$_PATH/resources/util/BniEnc.php";
    
    // URL utk simulasi pembayaran: http://dev.bni-ecollection.com/

    $data = file_get_contents('php://input');
    $data_json = json_decode($data, true);

    if (!$data_json) {
        echo '{"status":"999","message":"not allowed"}';
    } else {
        if ($data_json['client_id'] === $client_id) {
            $data_asli = BniEnc::decrypt($data_json['data'], $client_id, $secret_key);

            if (!$data_asli) {
                // handling jika waktu server salah/tdk sesuai atau secret key salah
                echo '{"status":"999","message":"waktu server tidak sesuai NTP atau secret key salah."}';
            } else {
                // insert data asli ke db
                /* $data_asli = array(
                        'trx_id' => '', // silakan gunakan parameter berikut sebagai acuan nomor tagihan
                        'virtual_account' => '',
                        'customer_name' => '',
                        'trx_amount' => '',
                        'payment_amount' => '',
                        'cumulative_payment_amount' => '',
                        'payment_ntb' => '',
                        'datetime_payment' => '',
                        'datetime_payment_iso8601' => '',
                ); */
                $idMember = $data_asli['trx_id'];
                $name = $data_asli['customer_name'];
                $dateTime = $data_asli['datetime_payment'];
                $amount = $data_asli['payment_amount'];
                $noVA = $data_asli['virtual_account'];
                
                //update saldo member
		$dataUpdateSaldo = '{
                    "detail": {
			"nomor_va": "' . $noVA . '",
                        "noid": "' . $idMember . '",
                        "action": "exec",
                        "nominal": "' . $amount . '",
                        "keterangan": "TOPUP VA",
                        "tujuan": "BNIS"
                    },
		    "noid":"0000000000010001","username":"ARIFAR1234","token":"NZJ6LF2U5M8YUQP2SBE5","appid":"ADWA1JMAG1KJZN8D"}';

                $urlService = "https://kartujajan.co.id/REQUEST_H2H/act/PROCESS/service_callback_bni/H2H/OK";
                $serviceResponse = BniEnc::accessService($urlService, $dataUpdateSaldo);
                
                echo '{"status":"000"}';
                
                BniEnc::writeLog("callbackbnis", $dataUpdateSaldo);
                BniEnc::writeLog("callbackbnis", $serviceResponse);
                
                exit;
            }
        }
    }
} catch (Exception $ex) {
    BniEnc::writeLog("callbackbnis", "Error : " . $ex);
    echo '{"status":"999","message":'. $ex->getMessage() .'}';
}
