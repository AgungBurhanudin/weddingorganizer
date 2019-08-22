<?php

namespace Libraries;

use Resources;

class FungsiAmpm {
    
    public static function ampmUrl(){
        return 'http://36.37.85.130:9998/';
//        return 'http://103.15.226.40:7423/';
    }
    
    public static function ampmNoid(){
        return '1001010';
//        return '1001011';
    }
    
    public static function ampmPin(){
        return 'EGofWOxoITWKEq4Wz2CU';
//        return 'WO0NSquT0iSV1ughrtb7';
    }
    
    public static function ampmPasswod(){
        return 'EGofWOxoITWKEq4Wz2CU';
//        return 'WO0NSquT0iSV1ughrtb7';
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
