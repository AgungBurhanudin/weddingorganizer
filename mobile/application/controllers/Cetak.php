<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller {

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
        render('buku');
    }
}