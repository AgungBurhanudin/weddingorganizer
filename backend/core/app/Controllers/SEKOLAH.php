<?php

namespace Controllers;

use Resources,
    Models;

class SEKOLAH extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        $this->rest = new Resources\Rest;
    }
    
    public function sekolah() {
        $db = new Models\DbSekolah();
        $sql = "SELECT kode_sekolah as value, nama_sekolah as label FROM tbl_sekolah;";
        $result = $db->multipleRow($sql);

        if (isset($result[0]->value)) {
            echo json_encode($result);
        } else {
            echo '[]';
        }
    }
    
    public function grup() {
        $db = new Models\DbSekolah();
        $sql = "SELECT grup_id as value, grup_nama as label FROM app_grup;";
        $result = $db->multipleRow($sql);

        if (!empty($result)) {
            echo json_encode($result);
        } else {
            echo '[]';
        }
    }
    
    public function cekVersion($your_version) {
        $db = new Models\Database();
        $sql = "SELECT setting_value as value FROM app_setting WHERE setting_name = 'android_version';";
        $result = $db->singleRow($sql);
		
		if(!empty($result)){
		
        if ($result->value == $your_version) {
			$replay = array(
				'response_code' => '0000',
				'response_message' => 'Aplikasi sudah terupdate'
			);
            echo json_encode($replay);
        } else {
			$replay = array(
				'response_code' => '9999',
				'response_message' => 'Silahkan Update Aplikasi Anda?'
			);
            echo json_encode($replay);
        }	
		} else {
			$replay = array(
				'response_code' => '9999',
				'response_message' => 'Silahkan Update Aplikasi Anda?'
			);
            echo json_encode($replay);
        }
    }
    

}
