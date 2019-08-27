<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Panitia extends CI_Controller {

    public $auth;
    public $group;
    public $id_company;
    public $id_wedding;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('wedding_model'));
        $this->auth = $this->session->userdata('auth');
        $this->group = $this->auth['group'];
        $this->id_company = $this->auth['company'];
        $this->id_wedding = $this->auth['id_wedding'];
        checkToken();
    }

    public function index() {
        $id = $this->id_wedding;
        if (empty($id) || $id == "") {
            redirect(base_url() . "Dashboard");
        }
        $wedding = $this->db->query("SELECT * FROM wedding WHERE id = '$id'")->row();
        if (empty($wedding)) {
            redirect(base_url() . "Dashboard");
        }
        $data = array(
            'id_wedding' => $id,
            'wedding' => $wedding,
            'panitia' => $this->db->query("SELECT
                                a.*,
                                b.id AS id_field,
                                b.nama_panitia 
                        FROM
                                wedding_panitia a
                                LEFT JOIN panitia_tipe b ON a.id_panitia_tipe = b.id 
                        ORDER BY
                                a.urutan ASC")->result()
        );
        render('paket/panitia', $data);
    }
}