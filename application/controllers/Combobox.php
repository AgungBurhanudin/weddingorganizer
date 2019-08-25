<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Combobox extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }
    
    public function vendor() {
        $kategori = $_GET['kategori'];
        $query = "SELECT a.*,b.nama_kategori FROM vendor a LEFT JOIN kategori_vendor b ON a.id_kategori = b.id WHERE a.id_kategori = '$kategori'";
        $data = $this->db->query($query)->result();
        echo "<option value=''>-- Pilih Vendor --</option>";
        foreach ($data as $val){
            echo "<option value='$val->id'>$val->vendor</option>";
        }
    }

}
