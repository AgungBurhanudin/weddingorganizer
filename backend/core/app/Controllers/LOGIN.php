<?php

namespace Controllers;

use Models;
use Resources;

class LOGIN extends Resources\Controller
{

    public function __construct()
    {
        parent::__construct();
        $fungsi        = new \Libraries\Fungsi();
        $request       = file_get_contents('php://input');
        $jreq          = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '', $request));
        $this->request = $request;
        $this->tipe    = strtoupper($jreq->tipe);

        $this->ip       = getenv('REMOTE_ADDR');
        $req_noid       = (isset($jreq->noid)) ? $jreq->noid : '';
        $this->appid    = (isset($jreq->appid)) ? $jreq->appid : '';
        $this->noid     = strtoupper($req_noid);
        $req_username   = (isset($jreq->username)) ? $jreq->username : '';
        $this->username = strtoupper($req_username);
        $req_password   = (isset($jreq->password)) ? $jreq->password : '';
        $this->pwd      = $req_password;
        $this->token    = strtoupper($jreq->token);

        $tipebrowser = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        if (strlen($this->appid) < 10 && $jreq->tipe == 'LOGIN') {
            $appid_browser = $fungsi->randomString(16);
        } else {
            $appid_browser = $this->appid;
        }

        $this->appid = preg_replace("/[^a-zA-Z0-9]/", "", $appid_browser);
        $clientData  = $this->appid;
        $secClient   = substr(base64_encode($appid_browser . $tipebrowser), 15, 50);

        $this->browserid = $secClient;
    }

    public function CEKUSERNAME($interface)
    {
        //bisa juga untuk cek device android apakah terdaftar
        $db    = new Models\Databases();
        $reply = new Models\LoginRespon();

        $reply->tipe      = 'CEKUSERNAME';
        $reply->interface = $interface;
        $reply->appid     = $this->appid;
        $data_appid       = $this->browserid . '#' . $this->appid;

        $sql = "select alias from tbl_member_channel "
            . "where appid = '$data_appid' and interface = '$interface' "
            . "order by last_used desc limit 1;";

        $arr_cek = $db->singleRow($sql);
        if (isset($arr_cek->alias)) {
            $reply->status   = "SUKSESCEKUSERNAME";
            $reply->username = $arr_cek->alias;
            $reply->message  = 'cek username berhasil';
        } else {
            $reply->status  = "GAGAL";
            $reply->message = 'username tidak tersedia';
        }
        echo json_encode($reply);
    }

    public function LOGIN($interface)
    {
        $db     = new Models\Databases();
        $reply  = new Models\LoginRespon();
        $fungsi = new \Libraries\Fungsi();
        $konfig = new \Libraries\Konfigurasi();

        $reply->tipe      = 'LOGIN';
        $reply->interface = $interface;

        $sql = "SELECT * FROM app_user WHERE user_user_name = '$this->username';";

        $arr_cek = $db->singleRow($sql);
        
        if (isset($arr_cek->user_id)) {
            $noid           = $arr_cek->user_id;
            $nama           = $arr_cek->user_real_name;
            $email          = $arr_cek->user_email;
            $passwd         = $arr_cek->user_password;
            $aplikasiid     = $arr_cek->appid;
            $aplikasiid_add = $this->browserid . '#' . $this->appid;
            
                if ($passwd == $this->pwd) {
                        //login sukses
                        $reply->status           = 'SUKSESLOGIN';
                        $reply->message          = 'Berhasil Login';
                        $reply->noid             = $noid;
                        $reply->username         = $this->username;
                        $reply->token            = $fungsi->randomString(20);
                        $reply->nama             = $nama;
                        $reply->appid            = $this->appid;
                        $strSqlUpLogin           = "update app_user set user_token = '$reply->token', last_used = now(), ip = '$this->ip', status = 1,"
                            . "appid = '$aplikasiid_add', salah_pin = 0 where user_id = '$noid' and user_real_name = '$this->username'";
                        
                        $db->query($strSqlUpLogin);
                } else {
                    $reply->message = 'Password tidak sama';
                }
            
        } else {
            $reply->message = 'Username tidak tersedia';
        }
        echo json_encode($reply);
    }

    public function CEKSESSION($interface)
    {
        $db             = new Models\Databases();
        $reply          = new Models\LoginRespon();
        $fungsi         = new \Libraries\Fungsi();
        $aplikasiid_add = $this->browserid . '#' . $this->appid;
        //$this->website;

        $reply->tipe      = 'CEKSESSION';

        $sql = "SELECT * FROM app_user WHERE appid = '$aplikasiid_add' "
            . "and user_token = '$this->token' "
            . "and user_user_name = '$this->username' "
            . "and last_used > DATE_SUB(NOW(),INTERVAL 60 MINUTE);";
        $arr_cek = $db->singleRow($sql);

        if (isset($arr_cek->user_user_name)) {
            $noid                    = $arr_cek->user_id;
            $reply->status           = "SUKSESCEKSESSION";
            $reply->nama             = $arr_cek->user_real_name;
            $reply->response_code    = '200';
            $reply->response_message = 'Session Login masih Aktif';
        } else {
            $reply->response_code    = '0099';
            $reply->response_message = 'Session Telah Habis';
            $reply->message          = 'Session Login telah Habis';
        }
        echo json_encode($reply);
    }

    public function LOGOUT($interface)
    {
        $db             = new Models\Databases();
        $reply          = new Models\LoginRespon();
        $aplikasiid_add = $this->browserid . '#' . $this->appid;
        $sql            = "update tbl_member_channel set token = '', last_used = '2015-01-01 01:01:01', ip = '' "
            . "where alias = '$this->username' and appid = '$aplikasiid_add' and token = '$this->token' and interface = '$interface';";
        $db->singleRow($sql);

        $reply->status    = 'SUKSESLOGOUT';
        $reply->tipe      = 'LOGOUT';
        $reply->interface = $interface;
        echo json_encode($reply);
    }

}
