<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wedding extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //    $this->load->model('Wedding_model');
        checkToken();
    }

    public function index()
    {
        render('wedding/data');
    }

    public function add()
    {
        render('wedding/add');
        if ($this->input->post('finish')) {
            $this->form_validation->set_rules('title', 'Judul', 'trim|required');
            $this->form_validation->set_rules('pengantin_pria', 'Pengantin Pria', 'trim|required');
            $this->form_validation->set_rules('pengantin_wanita', 'Pengantin Wanita', 'trim|required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
            $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
            $this->form_validation->set_rules('tempat', 'Tempat', 'trim|required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
            $this->form_validation->set_rules('tema', 'Tema', 'trim|required');
            $this->form_validation->set_rules('hashtag', 'Hashtag', 'trim|required');
            $this->form_validation->set_rules('penyelenggara', 'Penyelenggara', 'trim|required');
            $this->form_validation->set_rules('undangan', 'Undangan', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
        }
    }

    public function form()
    {
        $id = $_GET['id'];
        if (empty($id) || $id == "") {
            redirect(base_url() . "Wedding");
        }
        $wedding = $this->db->query("SELECT * FROM wedding WHERE id = '$id'")->row();
        //        if(empty($wedding)){
        //            redirect(base_url() . "Wedding");
        //        }
        $data = array(
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
                . "WHERE a.id_wedding = '$id'")->result()
        );
        render('wedding/form2', $data);
    }

    public function vendor()
    {
        $uri = $this->uri->segment(3);
        $id = $_GET['id'];
        if ($uri == "add") { } else if ($uri == "edit") { } else if ($uri == "delete") { }
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
