<?php

namespace Controllers;

use Resources,
    Models;

class WORK extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        $this->rest = new Resources\Rest;
    }
    
    public function pekerjaan() {
        $db = new Models\Databases();
        $param = file_get_contents('php://input');
        $jreq = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '',$param));
        $noid = $jreq->noid;
        $username = strtoupper($jreq->username);
        $token = $jreq->token;
		$tipebrowser = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $jreq->appid;
        $secClient = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid = $secClient;
		$interface = $jreq->detail->interface;
		$time_sess = '60';
		$ip = getenv('REMOTE_ADDR');
		 //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $sql = "SELECT id_pekerjaan as value, nama_pekerjaan as label FROM tbl_pekerjaan;";
        $result = $db->multipleRow($sql);

        if (isset($result[0]->value)) {
            echo json_encode($result);
        } else {
            echo '[]';
        }	
    }
    
    

}
