<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Upacara extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $key = "WHERE 1 = 1 ";
        $key .= "AND id_upacara = '0' ";
        if (isset($_GET['nama_upacara'])) {
            $key .= "AND nama_upacara LIKE '%" . $_GET['nama_upacara'] . "%'";
        }
        $data = array(
            'upacara_tipe' => $this->db->query("SELECT * FROM upacara_tipe $key")->result(),
            'key' => $_GET
        );
        render('setting/upacara/data', $data);
    }

    public function add() {
        $key['id'] = "";
        $data = array(
            'upacara_tipe' => $this->db->get_where("upacara_tipe", $key)->result(),
            'tipe' => 'add'
        );
        render('setting/upacara/form', $data);
    }

    public function edit() {
        $key['id'] = $this->input->get("id");
        $data = array(
            'upacara_tipe' => $this->db->get_where("upacara_tipe", $key)->result(),
            'kegiatan' => $this->db->query("SELECT * FROM upacara_tipe WHERE id_upacara = " . $key['id'])->result(),
            'id' => $key['id'],
            'tipe' => 'edit'
        );
        render("setting/upacara/form", $data);
    }

    public function simpan() {
        $id = $this->input->post("id");
        if (empty($id)) {
            $data = $_POST;
            $this->db->insert("upacara_tipe", $data);
            redirect(base_url() . 'Setting/Upacara');
        } else {
            $key['id'] = $id;
            $data = $_POST;
            $this->db->update("upacara_tipe", $data, $key);
            redirect(base_url() . 'Setting/Upacara');
        }
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['id'] = $id;
        $this->db->delete("upacara_tipe", $key);
        redirect(base_url() . 'Setting/Upacara');
    }

    public function field() {
        $key['id'] = $this->input->get("id");
        $key2['id_upacara_tipe'] = $this->input->get("id");
        $this->db->order_by("urutan", "asc");
        $acara_field = $this->db->get_where("upacara_field", $key2)->result();
        $data = array(
            'upacara_tipe' => $this->db->get_where("upacara_tipe", $key)->row(),
            'upacara_field' => $acara_field,
        );
        render("setting/upacara/field", $data);
    }

    public function getField() {
        $key['id'] = $this->input->get("id");
        $data = $this->db->get_where("upacara_field", $key)->row();
//        print_r($data);
        if ($data != null || !empty($data)) {
            $respon['resp_code'] = 200;
            $respon['data'] = $data;
            echo json_encode($respon);
            exit();
        }
        $respon['resp_code'] = 400;
        echo json_encode($respon);
        exit();
    }
    

    public function getKegiatan() {
        $key['id'] = $this->input->get("id");
        $data = $this->db->get_where("upacara_tipe", $key)->row();
//        print_r($data);
        if ($data != null || !empty($data)) {
            $respon['resp_code'] = 200;
            $respon['data'] = $data;
            echo json_encode($respon);
            exit();
        }
        $respon['resp_code'] = 400;
        echo json_encode($respon);
        exit();
    }

    public function saveField() {
        $this->load->model('app_model');
        $id = $this->input->post("id");
        $urutan = $this->app_model->getUrutanUpacaraField($_POST['id_upacara']);
        if (empty($id)) {
            $data['id_upacara_tipe'] = $_POST['id_upacara'];
            $data['nama_field'] = $_POST['nama_field'];
            $data['nama_label'] = $_POST['nama_label'];
            $data['type'] = $_POST['jenis_field'];
            $data['ukuran'] = $_POST['deskripsi_field'];
            $data['urutan'] = $urutan;
            // $data['isian'] = $_POST['id_upacara'];
            // $data['wajib'] = 1;
            // $data['urutan'] = $_POST['id_upacara'];
            $this->db->insert("upacara_field", $data);
        } else {
            $key['id'] = $id;
            $data['id_upacara_tipe'] = $_POST['id_upacara'];
            $data['nama_field'] = $_POST['nama_field'];
            $data['nama_label'] = $_POST['nama_label'];
            $data['type'] = $_POST['jenis_field'];
            $data['ukuran'] = $_POST['deskripsi_field'];
            $this->db->update("upacara_field", $data, $key);
        }
        $this->session->set_flashdata('success', 'Berhasil menambah data field');
        $resutl = array(
            "resp_code" => 200
        );
        echo json_encode($resutl);
    }
    
    public function saveKegiatan() {
        $this->load->model('app_model');
        $id = $this->input->post("id");
        $urutan = $this->app_model->getUrutanUpacaraKegiatan($_POST['id_upacara']);
        if (empty($id)) {
            $data['id_upacara'] = $_POST['id_upacara'];
            $data['nama_upacara'] = $_POST['nama_kegiatan'];
            $data['urutan'] = $urutan;
            $this->db->insert("upacara_tipe", $data);
        } else {
            $key['id'] = $id;
            $data['id_upacara'] = $_POST['id_upacara'];
            $data['nama_upacara'] = $_POST['nama_kegiatan'];
            $this->db->update("upacara_tipe", $data, $key);
        }
        $this->session->set_flashdata('success', 'Berhasil menambah data kegiatan');
        $resutl = array(
            "resp_code" => 200
        );
        echo json_encode($resutl);
    }

    public function deleteField() {
        $key['id'] = $this->input->get("id");
        $data = $this->db->delete("upacara_field", $key);
        $respon['resp_code'] = 200;
        echo json_encode($respon);
        exit();
    }

    public function deleteKegiatan() {
        $key['id'] = $this->input->get("id");
        $data = $this->db->delete("upacara_tipe", $key);
        $respon['resp_code'] = 200;
        echo json_encode($respon);
        exit();
    }

    public function saveUrutan() {
        $key['id'] = $_POST['id'];
        $data['urutan'] = $_POST['urutan'];
        $this->db->update('upacara_field', $data, $key);
        echo json_encode(array("resp_code" => "200"));
    }

}

/* End of file Upacara.php */
/* Location: ./application/controllers/Upacara.php */
