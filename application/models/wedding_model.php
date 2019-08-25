<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wedding_model extends CI_Model
{

    public function __construct()
    {
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

    public function rules_wedding()
    {
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

    public function rules_pria()
    {
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

    public function getDataAll()
    {
        // return $this->db->get($this->_table)->result();
        $this->db->select('wedding.*', 'pengantin.id_wedding', 'pengantin.lengkap', 'pengantin.nama_panggilan', 'pengantin.alamat_nikah', 'pengantin.gender');
        $this->db->join('wedding', 'pengantin.id_wedding = wedding.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function getData($id)
    {
        return $this->db->get_where($this->_table, ['id' => $id])->row();
    }

    public function insertWedding()
    {
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
        return $this->db->insertWedding();
    }

    public function insertPria($id_wedding)
    {
        $_POST = $this->input->post();
        $this->id = $id_wedding;
        $this->id_wedding = $_POST["id_wedding"];
        $this->gender = $_POST["gender"];
        $this->nama_lengkap = $_POST["nama_lengkap"];
        $this->nama_panggilan = $_POST['nama_panggilan'];
        $this->db->insert($this->pengantin, $this);
        return $this->db->insertPria();
    }

    public function insertWanita($id_wedding)
    {
        $_POST = $this->input->post();
        $this->id = $id_wedding;
        $this->id_wedding = $_POST["id_wedding"];
        $this->gender = $_POST["gender"];
        $this->nama_lengkap = $_POST["nama_lengkap"];
        $this->nama_panggilan = $_POST['nama_panggilan'];
        $this->db->insert($this->pengantin, $this);
        return $this->db->insertWanita();
    }

    public function insertAcara($id_wedding)
    {
        $_POST = $this->input->post();
        $this->id = $id_wedding;
        $this->id_wedding = $_POST["id_wedding"];
        $this->id_acara_tipe = $_POST["id_acara_tipe"];
        $this->urutan = $_POST["urutan"];
        $this->db->insert($this->wedding_acara, $this);
        return $this->db->insertAcara();
    }

    public function insertUpacara($id_wedding)
    {
        $_POST = $this->input->post();
        $this->id = $id_wedding;
        $this->id_wedding = $_POST["id_wedding"];
        $this->id_upacara_tipe = $_POST["id_upacara_tipe"];
        $this->urutan = $_POST["urutan"];
        $this->db->insert($this->wedding_upacara, $this);
        return $this->db->insertUpacara();
    }

    public function insertPanitia($id_wedding)
    {
        $_POST = $this->input->post();
        $this->id = $id_wedding;
        $this->id_wedding = $_POST["id_wedding"];
        $this->id_panitia_tipe = $_POST["id_panitia_tipe"];
        $this->urutan = $_POST["urutan"];
        $this->db->insert($this->wedding_panitia, $this);
        return $this->db->insertPanitia();
    }

    public function insertTambahan($id_wedding)
    {
        $_POST = $this->input->post();
        $this->id = $id_wedding;
        $this->id_wedding = $_POST["id_wedding"];
        $this->id_tambahan_tipe = $_POST["id_tambahan_tipe"];
        $this->urutan = $_POST["urutan"];
        $this->db->insert($this->wedding_tambahan, $this);
        return $this->db->insertTambahan();
    }

    public function update()
    {
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

    public function delete($id)
    {
        return $this->db->delete($this->_table, array('id' => $id));
    }
}
