<?php
set_time_limit(100);
session_start();
define('BASE_URL', 'http://127.0.0.1/daemon/core/public/index.php/');
define('USERNAME', 'ARIFAR1234');
define('PASSWORD', '123123');
define('APPID', '1RLXE27DNYKXFPTK');

function getCurlResult($url, $params) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    return curl_exec($ch);
}

function randomNumber($length = 12) {
    $chars = '123456789';

    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

function randomMin($length = 1) {
    $chars = '12345';

    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}