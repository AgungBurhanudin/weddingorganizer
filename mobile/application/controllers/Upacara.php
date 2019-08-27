<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Upacara extends CI_Controller {

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
            'upacara_parent' => $this->db->query("SELECT
                                        c.*
                                FROM
                                        wedding_upacara a
                                        LEFT JOIN upacara_tipe b ON a.id_upacara_tipe = b.id 
                                        LEFT JOIN upacara_tipe c ON b.id_upacara = c.id 
                                GROUP BY
                                        b.id_upacara 
                                ORDER BY
                                        a.urutan ASC")->result(),
            'upacara' => $this->db->query("SELECT
                                a.*,
                                b.id AS id_field,
                                b.id_upacara,
                                b.nama_upacara 
                        FROM
                                wedding_upacara a
                                LEFT JOIN upacara_tipe b ON a.id_upacara_tipe = b.id 
                        ORDER BY
                                a.urutan ASC")->result()
        );
        render('paket/upacara', $data);
    }

}
