<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function checkToken() {
    error_reporting(E_ALL);
    ini_set("display_errors", "1");
    $CI = & get_instance();
    $data = $CI->session->userdata('auth');
    if (empty($data) || $data == "" || !isset($data)) {
        header("location: " . base_url() . "Login");
    } else {
        $aplikasiid_add = $data['appid'];
        $token = $data['token'];
        $username = $data['username'];
        $sql = "SELECT * FROM app_user WHERE  "
                . " user_token = '$token' "
                . "and user_user_name = '$username' "
                . "and last_used > DATE_SUB(NOW(),INTERVAL 60 MINUTE);";
        $arr_cek = $CI->db->query($sql)->row();

        if (isset($arr_cek->user_user_name)) {
            //do nothing
            $sql_update = "UPDATE app_user SET  "
                    . "last_used = NOW() WHERE"
                    . " user_token = '$token' "
                    . " and user_user_name = '$username' ";
            $arr_update = $CI->db->query($sql_update);
        } else {
            header("location: " . base_url() . "Login");
        }
    }
}

function checkTokenLogin() {
    $CI = & get_instance();
    $data = $CI->session->userdata('auth');
    if (empty($data) || $data == "" || !isset($data)) {
        
    } else {
        $aplikasiid_add = $data['appid'];
        $token = $data['token'];
        $username = $data['username'];
        $sql = "SELECT * FROM app_user WHERE  "
                . " user_token = '$token' "
                . "and user_user_name = '$username' "
                . "and last_used > DATE_SUB(NOW(),INTERVAL 60 MINUTE);";
        $arr_cek = $CI->db->query($sql)->row();

        if (isset($arr_cek->user_user_name)) {
            header("location: " . base_url() . "Dashboard");
        } else {
            
        }
    }
}
