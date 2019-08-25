<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wedding extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('wedding_model'));
         $this->load->library('form_validation');
        checkToken();
    }

    public function index()
    {
        $data['wedding'] = $this->wedding_model->getDataAll();
        render('wedding/data', $data);
    }

    public function add()
    {
        //        render('wedding/add');
        //        if ($this->input->post('finish')) {
        //            $this->form_validation->set_rules('title', 'Judul', 'trim|required');
        //            $this->form_validation->set_rules('pengantin_pria', 'Pengantin Pria', 'trim|required');
        //            $this->form_validation->set_rules('pengantin_wanita', 'Pengantin Wanita', 'trim|required');
        //            $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        //            $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
        //            $this->form_validation->set_rules('tempat', 'Tempat', 'trim|required');
        //            $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        //            $this->form_validation->set_rules('tema', 'Tema', 'trim|required');
        //            $this->form_validation->set_rules('hashtag', 'Hashtag', 'trim|required');
        //            $this->form_validation->set_rules('penyelenggara', 'Penyelenggara', 'trim|required');
        //            $this->form_validation->set_rules('undangan', 'Undangan', 'trim|required');
        //            $this->form_validation->set_rules('status', 'Status', 'trim|required');
        //        }
        $data_upacara = $this->db->query("SELECT
		c1.id,		
                    p.id as parent_id,
                    p.nama_upacara as parent_name,    
                    c1.nama_upacara as child_name
                FROM 
                    upacara_tipe p
                LEFT JOIN upacara_tipe c1
                    ON c1.id_upacara = p.id
                WHERE
                    p.id_upacara=0 
                ORDER BY 
	 p.id, c1.urutan ASC")->result();
        $data = array(
            'upacara' => $data_upacara,
            'acara' => $this->db->query("SELECT * FROM acara_tipe")->result(),
            'panitia' => $this->db->query("SELECT * FROM panitia_tipe")->result(),
            'tambahan' => $this->db->query("SELECT * FROM tambahan_tipe")->result()
        );
        render('wedding/add', $data);
    }

    public function save()
    {
        $wedding = $this->wedding_model;
        $validation = $this->form_validation;
        $validation->set_rules($wedding->rules_wedding());
        $result = true;
        $msg = "";
        $id_wedding = "";

        //Insert Data Wedding ke Table wedding
        if ($validation->run()) {
            $id_wedding = $wedding->insertWedding();
            $result = $result && true;
        }
        if ($id_wedding == "") {
            $return = array(
                'code' => 400,
                'message' => "Gagal Di Tambahkan . " . $msg
            );
            echo json_encode($return);
            exit();
        }

        //Insert Data Wedding ke Table Pengantin
        $validation->set_rules($wedding->rules_pria());
        if ($validation->run()) {
            $wedding->insertPria($id_wedding);
            $result = $result && true;
        }

        //Insert Data Wedding ke Table Wanita
        $validation->set_rules($wedding->rules_wanita());
        if ($validation->run()) {
            $wedding->insertWanita($id_wedding);
            $result = $result && true;
        }


        //Insert Data Paket ke Table wedding_acara / wedding_panitia / wedding_upacra / wedding_tambahan        
        $result = $result && $wedding->insertPaketAcara($id_wedding);
        $result = $result && $wedding->insertPaketUpacara($id_wedding);
        $result = $result && $wedding->insertPaketPanitia($id_wedding);
        $result = $result && $wedding->insertPaketTambahan($id_wedding);


        if ($result) {
            $return = array(
                'code' => 200,
                'message' => "Berhasil Di Tambahkan"
            );
            echo json_encode($return);
            $this->session->set_flashdata('success', 'Berhasil Ditambahkan');
        } else {
            $return = array(
                'code' => 200,
                'message' => "Gagal Di Tambahkan . " . $msg
            );
            echo json_encode($return);
            $this->session->set_flashdata('error', 'Berhasil Ditambahkan');
        }
    }

    public function form()
    {
        $id = $_GET['id'];
        if (empty($id) || $id == "") {
            redirect(base_url() . "Wedding");
        }
        $wedding = $this->db->query("SELECT * FROM wedding WHERE id = '$id'")->row();
//        if (empty($wedding)) {
//            redirect(base_url() . "Wedding");
//        }
        $data = array(
            'id_wedding' => $id,
            'wedding' => $wedding,
            'pria' => $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'L'")->row(),
            'wanita' => $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'P'")->row(),
            'vendor' => $this->db->query("SELECT a.*,b.nama_kategori FROM vendor_pengantin a "
                . "LEFT JOIN kategori_vendor b "
                . "ON a.id_kategori = b.id "
                . "WHERE a.id_wedding = '$id'")->result(),
            'undangan' => $this->db->query("SELECT * FROM undangan WHERE id_wedding = '$id'")->result(),
            'meeting' => $this->db->query("SELECT * FROM jadwal_meeting WHERE id_wedding = '$id'")->result(),
            'log' => $this->db->query("SELECT a.*,b.user_real_name  FROM log_aktivitas a "
                    . "LEFT JOIN app_user b "
                    . "ON a.id_user = b.user_id "
                    . "WHERE a.id_wedding = '$id'")->result(),
            'kategori_vendor' => $this->db->get('kategori_vendor')->result(),
        );
        render('wedding/form2', $data);
    }

    public function vendor()
    {
        $uri = $this->uri->segment(3);        
        if ($uri == "add") {
            $return = array(
                'code' => '200',
                'msg' => 'Berhasil menambah vendor'
            );
            echo json_encode($return);
        } else if ($uri == "edit") {
            $id = $_GET['id'];
        } else if ($uri == "delete") {
            $id = $_GET['id'];
        }
    }

    public function meeting()
    {
        $uri = $this->uri->segment(3);
        $id = $_GET['id'];
        if ($uri == "add") { } else if ($uri == "edit") { } else if ($uri == "delete") { }
    }

    public function undangan()
    {
        $uri = $this->uri->segment(3);
        $id = $_GET['id'];
        if ($uri == "add") { } else if ($uri == "edit") { } else if ($uri == "delete") { }
    }
}

/* End of file Wedding.php */
/* Location: ./application/controllers/Wedding.php */
