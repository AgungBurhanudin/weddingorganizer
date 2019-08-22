<?php

namespace Libraries;

use Resources;

class FungsiIgt {
    
    public static function igtUrl(){
        return 'http://103.15.226.40:7433/';
    }
    
    public static function igtNoid(){
        return '1001010';
    }
    
    public static function igtToken(){
        return 'o0aZsBIA4FJF1uMsvwdH';
    }

    public static function getCurlResult($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        return curl_exec($ch);
    }

}
