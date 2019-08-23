<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


  function checkToken(){
    // echo "123";
    $CI = & get_instance();
    $data = $CI->session->userdata('auth');
    // print_r($data);
    // exit();
    if(empty($data) || $data == "" || !isset($data)){
      header("location: " . base_url() . "Login");
    }else{
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
      } else {
          header("location: " . base_url() . "Login");
      }
    }
    // echo "<pre>";
    // print_r($data);
    // exit();
  } 

  function checkTokenLogin(){
    // echo "123";
    $CI = & get_instance();
    $data = $CI->session->userdata('auth');
    // print_r($data);
    // exit();
    if(empty($data) || $data == "" || !isset($data)){
      // $CI->session->sess_destroy();
      // header("location: " . base_url() . "Login");
    }else{
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
        // $CI->session->sess_destroy();
          // header("location: " . base_url() . "Login");
      }
    }
    // echo "<pre>";
    // print_r($data);
    // exit();
  } 

