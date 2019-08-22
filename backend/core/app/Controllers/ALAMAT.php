<?php

namespace Controllers;

use Resources,
    Models;

class ALAMAT extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        $this->rest = new Resources\Rest;
    }
    
    public function provinces() {
        $db = new Models\DbAlamat();
        $sql = "SELECT id as value, name as label FROM provinces;";
        $result = $db->multipleRow($sql);

        if (isset($result[0]->value)) {
            echo json_encode($result);
        } else {
            echo '[]';
        }
    }
    
    public function regencies($id) {
        $db = new Models\DbAlamat();
        $sql = "SELECT id as value, name as label FROM regencies WHERE province_id = '$id'";
        $result = $db->multipleRow($sql);

        if (isset($result[0]->value)) {
            echo json_encode($result);
        } else {
            echo '[]';
        }
    }
    
    public function districts($id) {
        $db = new Models\DbAlamat();
        $sql = "SELECT id as value, name as label, regency_id FROM districts WHERE regency_id = '$id'";
        $result = $db->multipleRow($sql);

        if (isset($result[0]->value)) {
            echo json_encode($result);
        } else {
            echo '[]';
        }
    }
    
    public function villages($id) {
        $db = new Models\DbAlamat();
        $sql = "SELECT id as value, name as label FROM villages WHERE district_id = '$id'";
        $result = $db->multipleRow($sql);

        if (isset($result[0]->value)) {
            echo json_encode($result);
        } else {
            echo '[]';
        }
    }

}
