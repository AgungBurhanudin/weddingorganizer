<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function getMeta(){
    $q = "SELECT title, meta_text, meta_desc, meta_key,email,alamat,no_telp, judul_website FROM web_setting WHERE id=1";
    $data = mysql_query($q);
    return $data;
}

function getAkunWeb(){
    $q = "SELECT facebook, twitter, google_plus FROM web_setting WHERE id=1";
    $data = mysql_query($q);
    return $data;
}

function getAlamat(){
    $q = "SELECT no_telp, alamat, email FROM web_setting WHERE id=1";
    $data = mysql_query($q);
    return $data;
}



/* End of file websetting_helper.php */
/* Location: ./application/helpers/websetting_helper.php */