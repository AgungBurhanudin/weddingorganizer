<?php

namespace Libraries;

use Resources;

class FungsiHpay {
    
    public static function hpayUrl(){
        return 'https://h2h.bnisyariah.co.id/services/hpay_h2h_proxy';
    }
    
    public static function hpayNoid(){
        return '';
    }
    
    public function hpayHeader($rawdata) {
        $header[] = 'Authorization : Basic =';
        $header[] = 'x-api-key : ';
        $header[] = 'Expect: ';
        $header[] = 'x-signature : ' . hash('sha256', $rawdata);

        return $header;
    }

    public function hpayCurl($url, $data, $header = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if ($header != null) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);

        if (curl_errno($ch) > 0) {
            return 'Error ' . curl_error($ch);
        }

        return curl_exec($ch);
    }

}
