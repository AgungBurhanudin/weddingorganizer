<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
        $data = $this->wedding_model->getOneData($this->id_wedding);
        $data = array(
            'wedding' => $data
        );
        render('dashboard', $data);
    }

    public function biodata() {
        $id = $this->id_wedding;
        $data = array(
            'pria' => $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'L'")->row(),
            'wanita' => $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'P'")->row(),
            'id_wedding' => $id
        );
        render('biodata', $data);
    }

    public function saveBiodataPria() {
        $id = $this->id_wedding;
        $data['id_wedding'] = $id;
        $data['gender'] = "L";
        $data['nama_lengkap'] = isset($_POST["nama_lengkap_pria"]) ? $_POST["nama_lengkap_pria"] : "";
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
            $path = realpath(APPPATH . '../../files/images/');

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
//                $data['photo'] = "";
            }
        } else {
//            $data['photo'] = "";
        }

        $key['id'] = $_POST['id'];
        $this->db->update('pengantin', $data, $key);
        redirect(base_url() . "Dashboard/biodata");
    }

    public function saveBiodataWanita() {
        $id = $this->id_wedding;
        $_POST = $this->input->post();
        $data['id_wedding'] = $id;
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
            $path = realpath(APPPATH . '../../files/images/');

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
//                $data['photo'] = "";
            }
        } else {
//            $data['photo'] = "";
        }
        $key['id'] = $_POST['id'];
        $this->db->update('pengantin', $data, $key);
        redirect(base_url() . "Dashboard");
    }

    public function meeting() {
        $id = $this->id_wedding;
        $data = array(
            'meeting' => $this->db->query("SELECT * FROM jadwal_meeting WHERE id_wedding = '$id'")->result(),
        );
        render('meeting', $data);
    }

    public function vendor() {
        $id = $this->id_wedding;
        $data = array(
            'vendor' => $this->db->query("SELECT a.*,b.nama_kategori FROM vendor_pengantin a "
                    . "LEFT JOIN kategori_vendor b "
                    . "ON a.id_kategori = b.id "
                    . "WHERE a.id_wedding = '$id'")->result(),
        );
        render('vendor', $data);
    }

    public function addVendor() {
        $id = $this->id_wedding;
        $data = array(
            'vendor' => $this->db->query("SELECT a.*,b.nama_kategori FROM vendor_pengantin a "
                    . "LEFT JOIN kategori_vendor b "
                    . "ON a.id_kategori = b.id "
                    . "WHERE a.id_wedding = '$id'")->result(),
            'kategori_vendor' => $this->db->get('kategori_vendor')->result(),
            'id_wedding' => $id
        );
        render('addVendor', $data);
    }

    public function saveVendor() {
        $post = $_POST;
        $id = $this->id_wedding;
        $data = array(
            'id_kategori' => $post['vendor'],
            'id_vendor' => $post['kategori_vendor'],
            'id_wedding' => $post['id_wedding'],
            'nama_vendor' => $post['nama_vendor'],
            'cp' => $post['cp'],
            'nohp_cp' => $post['nohp'],
            'biaya' => $post['biaya'],
            'dibayaroleh' => $post['bayar_oleh'],
        );
        $this->db->insert('vendor_pengantin', $data);
        $this->vendor();
    }

    public function payment() {
        render('payment');
    }

    public function contactus() {
        $id = $this->id_company;
        $data = array(
            'company' => $this->db->query("SELECT * FROM company WHERE id = '$id'")->row(),
        );
        render('contactus', $data);
    }

    public function layout() {
        render('layout');
    }

    public function log() {
        $id = $this->id_wedding;
        $data = array(
            'log' => $this->db->query("SELECT a.*,b.user_real_name  FROM log_aktivitas a "
                    . "LEFT JOIN app_user b "
                    . "ON a.id_user = b.user_id "
                    . "WHERE a.id_wedding = '$id' ORDER BY datetime DESC LIMIT 10")->result(),
        );
        render('log', $data);
    }

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */