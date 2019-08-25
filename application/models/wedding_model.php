<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wedding_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table = 'wedding';
    public $id;
    public $id_company;
    public $title;
    public $pengantin_pria;
    public $pengantin_wanita;
    public $tanggal;
    public $waktu;
    public $tempat;
    public $tema;
    public $alamat;
    public $hashtag;
    public $penyelenggara;
    public $undangan;
    public $status;

    public function rules_wedding() {
        return [
            ['field' => 'title', 'label' => 'Title', 'rules' => 'required'],
            ['field' => 'pengantin_pria', 'label' => 'Pengantin Pria', 'rules' => 'required'],
            ['field' => 'pengantin_wanita', 'label' => 'Pengantin Wanita', 'rules' => 'required'],
            ['field' => 'tanggal', 'label' => 'Tanggal', 'rules' => 'required'],
            ['field' => 'waktu', 'label' => 'Waktu', 'rules' => 'required'],
            ['field' => 'tempat', 'label' => 'Tempat', 'rules' => 'required'],
            ['field' => 'tema', 'label' => 'Tema', 'rules' => 'required'],
            ['field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required'],
            ['field' => 'hashtag', 'label' => 'Hashtag', 'rules' => 'required'],
            ['field' => 'penyelenggara', 'label' => 'Penyelenggara', 'rules' => 'required'],
            ['field' => 'undangan', 'label' => 'Undangan', 'rules' => 'required'],
            ['field' => 'status', 'label' => 'Status', 'rules' => 'required'],
        ];
    }
    
    public function rules_pria() {
        return [
            ['field' => 'title', 'label' => 'Title', 'rules' => 'required'],
            ['field' => 'pengantin_pria', 'label' => 'Pengantin Pria', 'rules' => 'required'],
            ['field' => 'pengantin_wanita', 'label' => 'Pengantin Wanita', 'rules' => 'required'],
            ['field' => 'tanggal', 'label' => 'Tanggal', 'rules' => 'required'],
            ['field' => 'waktu', 'label' => 'Waktu', 'rules' => 'required'],
            ['field' => 'tempat', 'label' => 'Tempat', 'rules' => 'required'],
            ['field' => 'tema', 'label' => 'Tema', 'rules' => 'required'],
            ['field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required'],
            ['field' => 'hashtag', 'label' => 'Hashtag', 'rules' => 'required'],
            ['field' => 'penyelenggara', 'label' => 'Penyelenggara', 'rules' => 'required'],
            ['field' => 'undangan', 'label' => 'Undangan', 'rules' => 'required'],
            ['field' => 'status', 'label' => 'Status', 'rules' => 'required'],
        ];
    }

    public function getDataAll() {
        return $this->db->get($this->_table)->result();
    }

    public function getData($id) {
        return $this->db->get_where($this->_table, ['id' => $id])->row();
    }

    public function insertWedding() {
        $_POST = $this->input->post();
        $this->id = $_POST["id"];
        $this->id_company = $_POST["id_company"];
        $this->title = $_POST["title"];
        $this->pengantin_pria = $_POST["pengantin_pria"];
        $this->pengantin_wanitan = $_POST["pengantin_wanitan"];
        $this->tanggal = $_POST["tanggal"];
        $this->waktu = $_POST["waktu"];
        $this->tempat = $_POST["tempat"];
        $this->alamat = $_POST["alamat"];
        $this->tema = $_POST["tema"];
        $this->hashtag = $_POST["hashtag"];
        $this->penyelenggara = $_POST["penyelenggara"];
        $this->undangan = $_POST["undangan"];
        $this->status = $_POST["status"];
        $this->db->insert($this->_table, $this);
        return $this->db->insert_id();
    }
    
    public function insertPria($id_wedding) {
        
    }
    
    public function insertWanita($id_wedding) {
        
    }
    
    public function insertAcara($id_wedding) {
        
    }
        
    public function insertUpacara($id_wedding) {
        
    }
    
    public function insertPanitia($id_wedding) {
        
    }
        
    public function insertTambahan($id_wedding) {
        
    }

    public function update() {
        $_POST = $this->input->post();
        $this->id = $_POST["id"];
        $this->id_company = $_POST["id_company"];
        $this->title = $_POST["title"];
        $this->pengantin_pria = $_POST["pengantin_pria"];
        $this->pengantin_wanitan = $_POST["pengantin_wanitan"];
        $this->tanggal = $_POST["tanggal"];
        $this->waktu = $_POST["waktu"];
        $this->tempat = $_POST["tempat"];
        $this->alamat = $_POST["alamat"];
        $this->tema = $_POST["tema"];
        $this->hashtag = $_POST["hashtag"];
        $this->penyelenggara = $_POST["penyelenggara"];
        $this->undangan = $_POST["undangan"];
        $this->status = $_POST["status"];
        $this->db->update($this->_table, array("id" => $_POST['$id']));
    }

    public function delete($id) {
        return $this->db->delete($this->_table, array('id' => $id));
    }

}
