<?php

namespace Controllers;

use Resources,
    Models,
    Libraries;

class RPAGING extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        set_time_limit(150);
    }

    //proteksi ip
    public function act($tipe_file, $tipe_request, $interface) {
        $fungsi = new Libraries\Fungsi;
        $wLog = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error = new Libraries\ResponseError;

        $db = new Models\Databases();
//        $param = file_get_contents('php://input');
        $param = json_encode($_POST);
        $jreq = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '',$param));
        $noid = $jreq->noid;
        $username = strtoupper($jreq->username);
        $token = $jreq->token;
        $tipebrowser = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $jreq->appid;
        $secClient = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid = $secClient;
        $time_sess = '60';
        $ip = getenv('REMOTE_ADDR');
        $ref = date("ymdH").$fungsi->randomNumber(8);
        $wLog->writeLog($interface, 'RPAGING_'.$tipe_request, $param);
        
        //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $arr_member = $db->cekNoidMember($noid);
        $nama_member = $arr_member->nama;
        $tipe_member = $arr_member->tipe;
        $jenis_member = $arr_member->jenis;
        $saldo_member = $arr_member->saldo;

        //cek menu status hak akses
        $arr_menu = $db->singleRow("SELECT id,perintah,aturan,hak_akses,validasi,status,keterangan FROM tbl_menu WHERE perintah = '$tipe_request'");
        if (!isset($arr_menu->status)) {
            $error->menuTidakAda($saldo_member);
        }
        $status_menu = $arr_menu->status;
        $hak_akses = $arr_menu->hak_akses;
        $otorisasi = $arr_menu->validasi;
        $keterangan_menu = $arr_menu->keterangan;

        //validasi hak akses
        if ($status_menu != 1) {
            $error->menuTidakBerhak($saldo_member);
        }

        if (strpos($hak_akses, $tipe_member) !== false || strlen($hak_akses) < 2) {
            include "$tipe_file/$tipe_request.php";
        } else {
            $error->menuTidakBerhak($saldo_member);
        }

    }

}
