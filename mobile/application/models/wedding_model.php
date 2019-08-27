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
    public $registration_date;

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
        // return $this->db->get($this->_table)->result();
//        $this->db->select('wedding.*', 'pengantin.id_wedding', 'pengantin.lengkap', 'pengantin.nama_panggilan', 'pengantin.alamat_nikah', 'pengantin.gender');
//        $this->db->join('wedding', 'pengantin.id_wedding = wedding.id');
        $sql = "SELECT a.*,
                b.nama_panggilan AS nama_pria, 
                c.nama_panggilan AS nama_wanita,
                b.photo AS foto_pria, 
                c.photo AS foto_wanita,
                e.user_real_name,
                d.datetime,
                d.deskripsi,
                a.registration_date,
                CONCAT(b.no_hp , '<br>', c.no_hp) AS cp
                FROM wedding a   
              LEFT JOIN 
                (SELECT id_wedding,nama_lengkap, nama_panggilan, alamat_nikah, photo, no_hp 
                FROM pengantin 
                WHERE gender = 'L' ) b 
              ON b.id_wedding = a.id 
              LEFT JOIN 
                (SELECT id_wedding,nama_lengkap, nama_panggilan, alamat_nikah, photo, no_hp
                FROM pengantin 
                WHERE gender = 'P' ) c 
              ON c.id_wedding = a.id 
              LEFT JOIN 
                (SELECT * FROM log_aktivitas GROUP BY id_wedding ORDER BY datetime DESC LIMIT 1) d 
              ON d.id_wedding = a.id 
              LEFT JOIN app_user e 
              ON d.id_user = e.user_id 
              WHERE a.status = 1
              ORDER BY a.tanggal DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getOneData($id_wedding) {
        $where = "AND a.id = '$id_wedding'";
        $sql = "SELECT a.*,
                b.nama_panggilan AS nama_pria, 
                c.nama_panggilan AS nama_wanita,
                b.photo AS foto_pria, 
                c.photo AS foto_wanita,
                e.user_real_name,
                d.datetime,
                d.deskripsi,
                a.registration_date,
                CONCAT(b.no_hp , '<br>', c.no_hp) AS cp
                FROM wedding a   
              LEFT JOIN 
                (SELECT id_wedding,nama_lengkap, nama_panggilan, alamat_nikah, photo, no_hp 
                FROM pengantin 
                WHERE gender = 'L' ) b 
              ON b.id_wedding = a.id 
              LEFT JOIN 
                (SELECT id_wedding,nama_lengkap, nama_panggilan, alamat_nikah, photo, no_hp
                FROM pengantin 
                WHERE gender = 'P' ) c 
              ON c.id_wedding = a.id 
              LEFT JOIN 
                (SELECT * FROM log_aktivitas GROUP BY id_wedding ORDER BY datetime DESC LIMIT 1) d 
              ON d.id_wedding = a.id 
              LEFT JOIN app_user e 
              ON d.id_user = e.user_id 
              WHERE a.status = 1 $where 
              ORDER BY a.tanggal DESC";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getData($id) {
        return $this->db->get_where($this->_table, ['id' => $id])->row();
    }

    public function insertWedding() {
        $_POST = $this->input->post();
        $this->id_company = ""; //$_POST["id_company"];
        $this->title = $_POST["title"];
        $this->pengantin_pria = $_POST["nama_lengkap_pria"];
        $this->pengantin_wanita = $_POST["nama_lengkap_wanita"];
        $this->tanggal = $_POST["tanggal_pernikahan"];
        $this->waktu = $_POST["waktu_pernikahan"];
        $this->tempat = $_POST["lokasi_pernikahan"];
        $this->alamat = $_POST["alamat_pernikahan"];
        $this->tema = $_POST["tema_pernikahan"];
        $this->hashtag = $_POST["hastag_pernikahan"];
        $this->penyelenggara = $_POST["penyelenggara"];
        $this->undangan = $_POST["jumlah_undangan"];
        $this->status = 1;
        $this->registration_date = date('Y-m-d H:i:s');
        $this->db->insert($this->_table, $this);
        return $this->db->insert_id();
    }

    public function insertPria($id_wedding) {
        $_POST = $this->input->post();
        $data['id_wedding'] = $id_wedding;
        $data['gender'] = "L";
        $data['nama_lengkap'] = $_POST["nama_lengkap_pria"];
        $data['nama_panggilan'] = $_POST['nama_panggilan_pria'];
        $data['alamat_sekarang'] = $_POST['alamat_sekarang_pria'];
        $data['alamat_nikah'] = $_POST['alamat_nikah_pria'];
        $data['tempat_lahir'] = $_POST['tempat_lahir_pria'];
        $data['tanggal_lahir'] = $_POST['tanggal_lahir_pria'];
        $data['no_hp'] = $_POST['no_hp_pria'];
        $data['agama'] = $_POST['agama_pria'];
        $data['pendidikan'] = $_POST['pendidikan_pria'];
        $data['hobi'] = $_POST['hobi_pria'];
        $data['sosmed'] = 1;
        $data['status'] = 1;

        if (isset($_FILES)) {
            $path = realpath(APPPATH . '../files/images/');

            $this->upload->initialize(array(
                'upload_path' => $path,
                'allowed_types' => 'png|jpg|gif',
                'max_size' => '5000',
                'max_width' => '3000',
                'max_height' => '3000'
            ));

            if ($this->upload->do_upload('foto_pria')) {
                $data_upload = $this->upload->data();
                $this->image_lib->initialize(array(
                    'image_library' => 'gd2',
                    'source_image' => $path . '/' . $data_upload['file_name'],
                    'maintain_ratio' => false,
                    //  'create_thumb' => true,
                    'overwrite' => TRUE
                ));
                if ($this->image_lib->resize()) {
                    $data['photo'] = $data_upload['raw_name'] . $data_upload['file_ext'];
                } else {
                    $data['photo'] = $data_upload['file_name'];
                }
            } else {
                $data['photo'] = "";
            }
        } else {
            $data['photo'] = "";
        }
        return $this->db->insert('pengantin', $data);
    }

    public function insertWanita($id_wedding) {
        $_POST = $this->input->post();
        $data['id_wedding'] = $id_wedding;
        $data['gender'] = "P";
        $data['nama_lengkap'] = $_POST["nama_lengkap_wanita"];
        $data['nama_panggilan'] = $_POST['nama_panggilan_wanita'];
        $data['alamat_sekarang'] = $_POST['alamat_sekarang_wanita'];
        $data['alamat_nikah'] = $_POST['alamat_nikah_wanita'];
        $data['tempat_lahir'] = $_POST['tempat_lahir_wanita'];
        $data['tanggal_lahir'] = $_POST['tanggal_lahir_wanita'];
        $data['no_hp'] = $_POST['no_hp_wanita'];
        $data['agama'] = $_POST['agama_wanita'];
        $data['pendidikan'] = $_POST['pendidikan_wanita'];
        $data['hobi'] = $_POST['hobi_wanita'];
        $data['sosmed'] = $_POST['sosmed_wanita'];
        $data['status'] = 1;
        if (isset($_FILES)) {
            $path = realpath(APPPATH . '../files/images/');

            $this->upload->initialize(array(
                'upload_path' => $path,
                'allowed_types' => 'png|jpg|gif',
                'max_size' => '5000',
                'max_width' => '3000',
                'max_height' => '3000'
            ));

            if ($this->upload->do_upload('foto_wanita')) {
                $data_upload = $this->upload->data();
                $this->image_lib->initialize(array(
                    'image_library' => 'gd2',
                    'source_image' => $path . '/' . $data_upload['file_name'],
                    'maintain_ratio' => false,
                    //  'create_thumb' => true,
                    'overwrite' => TRUE
                ));
                if ($this->image_lib->resize()) {
                    $data['photo'] = $data_upload['raw_name'] . $data_upload['file_ext'];
                } else {
                    $data['photo'] = $data_upload['file_name'];
                }
            } else {
                $data['photo'] = "";
            }
        } else {
            $data['photo'] = "";
        }
        return $this->db->insert('pengantin', $data);
    }

    public function insertAcara($id_wedding) {
        $_POST = $this->input->post();
        $acara = $_POST['acara'];
        $no = 1;
        if (!empty($acara)) {
            foreach ($acara as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_acara_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_acara', $data);
            }
        }
        return true;
    }

    public function insertUpacara($id_wedding) {
        $_POST = $this->input->post();
        $upacara = $_POST['upacara'];
        $no = 1;
        if (!empty($upacara)) {
            foreach ($upacara as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_upacara_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_upacara', $data);
            }
        }
        return true;
    }

    public function insertPanitia($id_wedding) {
        $_POST = $this->input->post();
        $panitia = $_POST['panitia'];
        $no = 1;
        if (!empty($panitia)) {
            foreach ($panitia as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_panitia_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_panitia', $data);
            }
        }
        return true;
    }

    public function insertTambahan($id_wedding) {
        $_POST = $this->input->post();
        $tambahan = $_POST['tambahan'];
        $no = 1;
        if (!empty($tambahan)) {
            foreach ($tambahan as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_tambahan_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_tambahan', $data);
            }
        }
        return true;
    }

    public function insertLog($id_wedding, $deskripsi) {
        $_SESSION = $this->session->userdata('auth');
        $data['id_wedding'] = $id_wedding;
        $data['id_user'] = $_SESSION['noid'];
        $data['username'] = $_SESSION['username'];
        $data['deskripsi'] = $deskripsi;
        $data['datetime'] = date('Y-m-d H:i:s');        
        $this->db->insert('log_aktivitas', $data);
        return true;
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
