<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->ip = getenv('REMOTE_ADDR');
        $this->tipebrowser = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $this->browserid = substr(base64_encode($this->tipebrowser), 15, 50);
        $this->appid = "fsf45f6f4as5sa1fs3f16f4as1f3sa1f5sa3f";
    }

    public function index() {
        checkTokenLogin();
        $this->load->view('login');
    }

    public function login() {
        session_start();
        $reply['tipe'] = 'LOGIN';
        $reply['interface'] = 'WEB';
        $post = $_POST;

        $sql = "SELECT * FROM app_user WHERE user_user_name = '" . $post['username'] . "';";
        // echo $sql;
        $arr_cek = $this->db->query($sql)->row();

        if (isset($arr_cek->user_id)) {
            $noid = $arr_cek->user_id;
            $nama = $arr_cek->user_real_name;
            $email = $arr_cek->user_email;
            $passwd = $arr_cek->user_password;
            $aplikasiid = $arr_cek->appid;
            $group = $arr_cek->user_group_id;
            $company = $arr_cek->user_company;
            $id_wedding = $arr_cek->id_wedding;
            $aplikasiid_add = $this->browserid . '#' . $aplikasiid;
            if ($group != 37) {
                $reply['code'] = '401';
                $reply['message'] = 'Anda tidak punya akses di halaman ini';
                $this->load->view('login', $reply);
            } else {
                if ($passwd == md5($post['password'])) {
                    //login sukses
                    $reply['code'] = '200';
                    $reply['message'] = 'Sukses Login';
                    $reply['auth']['status'] = 'SUKSESLOGIN';
                    $reply['auth']['message'] = 'Berhasil Login';
                    $reply['auth']['noid'] = $noid;
                    $reply['auth']['username'] = $post['username'];
                    $reply['auth']['token'] = randomString(20);
                    $reply['auth']['nama'] = $nama;
                    $reply['auth']['appid'] = $aplikasiid_add;
                    $reply['auth']['group'] = $group;
                    $reply['auth']['company'] = $company;
                    $reply['auth']['id_wedding'] = $id_wedding;
                    // $this->session->session_start();

                    $this->session->set_userdata($reply);
                    $strSqlUpLogin = "update app_user set user_token = '" . $reply['auth']['token'] . "', last_used = now(), ip = '$this->ip', status = 1,"
                            . "appid = '$aplikasiid_add', salah_pin = 0 where user_id = '$noid' and user_real_name = '" . $post['username'] . "'";

                    $this->db->query($strSqlUpLogin);
                    redirect(base_url() . 'Dashboard');
//                exit();
                } else {
                    $reply['code'] = '401';
                    $reply['message'] = 'Password tidak sama';
                    $this->load->view('login', $reply);
//                exit();
                }
            }
        } else {
            $reply['code'] = '401';
            $reply['message'] = 'Username tidak tersedia';
            $this->load->view('login', $reply);
//            exit();
        }
//        echo json_encode($reply);
    }

    public function logout() {
        $this->session->unset_userdata('auth');
        $this->session->sess_destroy();
        header("location:" . base_url() . "Login");
    }

}
