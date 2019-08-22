<?php

namespace Controllers;

use Models;
use Resources;

class LOGIN_GURU extends Resources\Controller
{

    public function __construct()
    {
        parent::__construct();
        $fungsi        = new \Libraries\Fungsi();
        $request       = file_get_contents('php://input');
        $jreq          = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '', $request));
        // $this->request = $request;
        // $this->tipe    = strtoupper($jreq->tipe);

        $this->ip       = getenv('REMOTE_ADDR');
        // $this->website  = $jreq->website;
        // $req_noid       = (isset($jreq->noid)) ? $jreq->noid : '';
        // $this->appid    = (isset($jreq->appid)) ? $jreq->appid : '';
        // $this->noid     = strtoupper($req_noid);
        // $req_username   = (isset($jreq->username)) ? $jreq->username : '';
        // $this->username = strtoupper($req_username);
        // $req_password   = (isset($jreq->password)) ? $jreq->password : '';
        // $this->pwd      = $req_password;
        // $this->token    = strtoupper($jreq->token);

        $this->nohp_email  = $jreq->nohp;
        $this->username  = $jreq->nohp;
        $this->password  = $jreq->password;
        $this->appid    = (isset($jreq->appid)) ? $jreq->appid : '';

        $tipebrowser = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        if (strlen($this->appid) < 10) {
            $appid_browser = $fungsi->randomString(16);
        } else {
            $appid_browser = $this->appid;
        }

        //$this->appid = preg_replace("/[^a-zA-Z0-9]/", "", $appid_browser);
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

        $sql = "select nama from tbl_guru "
            . "where appid = '$data_appid' "
            . "order by last_used desc limit 1;";

        $arr_cek = $db->singleRow($sql);
        if (isset($arr_cek->alias)) {
            $reply->status   = "SUKSESCEKUSERNAME";
            $reply->username = $arr_cek->nama;
            $reply->message  = 'cek username berhasil';
        } else {
            $reply->status  = "GAGAL";
            $reply->message = 'username tidak tersedia';
        }
        echo json_encode($reply);
    }

    public function LOGIN($interface)
    {
        $db     = new Models\DbSekolah();
        $reply  = new Models\LoginRespon();
        $fungsi = new \Libraries\Fungsi();
        $konfig = new \Libraries\Konfigurasi();

        $reply->tipe      = 'LOGIN';
        $reply->interface = $interface;

        $sql = "SELECT * FROM tbl_guru  "
            . "where nohp = '$this->nohp_email';";

        $arr_cek = $db->singleRow($sql);
        if (isset($arr_cek->nip)) {
            $noid           = $arr_cek->nip;
            $nama           = $arr_cek->nama;
            $nohp_email     = $arr_cek->nohp;
            $alamat         = $arr_cek->alamat;
            $status         = $arr_cek->status;
            $passwd         = $arr_cek->password;
            $aplikasiid     = $arr_cek->appid;
            $aplikasiid_add = $this->appid;

            if ($status == 1) {
                if (md5($passwd) == $this->password) {
                    if ($aplikasiid == $aplikasiid_add) {
                        //login sukses
                        $reply->status           = 'SUKSESLOGIN';
                        $reply->message          = 'Berhasil Login';
                        $reply->noid             = $noid;
                        $reply->username         = $this->username;
                        $reply->token            = $fungsi->randomString(20);
                        $reply->nama             = $nama;
                        $reply->alamat           = $alamat;
                        $reply->appid            = $this->appid;
                        $strSqlUpLogin           = "update tbl_guru set token = '$reply->token', last_used = now(), ip = '$this->ip', status = 1,"
                            . "appid = '$aplikasiid_add', salah_pin = 0 where nip = '$noid' and nohp = '$nohp_email'";
                        $db->singleRow($strSqlUpLogin);
                    }else{
                        $reply->message = "ID Aplikasi berbeda";
                    } 
                } else {
                    //salah password, update salah password
                    $strSqlSp = "update tbl_guru set salah_pin = salah_pin + 1 "
                        . "where nohp = '$this->username' returning salah_pin";
                    $arr_sp         = $db->singleRow($strSqlSp);
                    $salah_pin      = $arr_sp->salah_pin;
                    $reply->message = 'Gagal Salah Password ' . $salah_pin . ' kali';
                    if ($salah_pin > 4) {
                        $strSqlBlok = "update tbl_guru set status = 0, salah_pin = 0 where nohp = '$this->username' ";
                        $db->singleRow($strSqlBlok);
                        $reply->message = 'Akun anda telah terblokir, silahkan mengulang registrasi aplikasi';
                    }
                }
            
            } else {
                $reply->message = 'Akun anda diblokir. Silahkan menghubungi Customer Service kami melalui live chat';
            }
        } else {
            $reply->message = 'Username tidak tersedia';
        }
        echo json_encode($reply);
    }

    public function CEKSESSION($interface)
    {
        $db             = new Models\DbSekolah();
        $reply          = new Models\LoginRespon();
        $fungsi         = new \Libraries\Fungsi();
        $aplikasiid_add = $this->browserid . '#' . $this->appid;
        //$this->website;

        $reply->tipe      = 'CEKSESSION';
        $reply->interface = $interface;

        $sql = "select * from tbl_guru  "
            . "where appid = '$aplikasiid_add' and token = '$this->token' "
            . " and  nohp = '$this->username' "
            . "and last_used > now() - interval '60 minutes';";
        $arr_cek = $db->singleRow($sql);

        if (isset($arr_cek->nohp)) {
            $noid             = $arr_cek->nip;

            $jeniswebsite            = $arr_cek->tipe . $this->website;
            $reply->status           = "SUKSESCEKSESSION";
            $reply->nama             = $arr_cek->nama;
            $reply->message          = 'Session Login masih Aktif';
        } else {
            $reply->response_code    = '0099';
            $reply->response_message = 'Session Telah Habis';
            $reply->message          = 'Session Login telah Habis';
        }
        echo json_encode($reply);
    }


}
