<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Acara extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $key = "WHERE 1 = 1 ";
        if (isset($_GET['nama_acara'])) {
            $key .= "AND nama_acara LIKE '%" . $_GET['nama_acara'] . "%'";
        }
        $data = array(
            'acara_tipe' => $this->db->query("SELECT * FROM acara_tipe $key")->result(),
            'key' => $_GET
        );
        render('setting/acara/data', $data);
    }

    public function add() {
        $key['id'] = "";
        $data = array(
            'acara_tipe' => $this->db->get_where("acara_tipe", $key)->result(),
        );
        render('setting/acara/form', $data);
    }

    public function edit() {
        $key['id'] = $this->input->get("id");
        $data = array(
            'acara_tipe' => $this->db->get_where("acara_tipe", $key)->result(),
        );
        render("setting/acara/form", $data);
    }

    public function simpan() {
        $id = $this->input->post("id");
        if (empty($id)) {
            $data = $_POST;
            $this->db->insert("acara_tipe", $data);
            redirect(base_url() . 'Setting/Acara');
        } else {
            $key['id'] = $id;
            $data = $_POST;
            $this->db->update("acara_tipe", $data, $key);
            redirect(base_url() . 'Setting/Acara');
        }
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['id'] = $id;
        $this->db->delete("acara_tipe", $key);
        redirect(base_url() . 'Setting/Acara');
    }

    public function field() {
        $key['id'] = $this->input->get("id");
        $key2['id_acara_tipe'] = $this->input->get("id");
        $this->db->order_by("urutan", "asc");
        $acara_field = $this->db->get_where("acara_field", $key2)->result();
        $data = array(
            'acara_tipe' => $this->db->get_where("acara_tipe", $key)->row(),
            'acara_field' => $acara_field,
        );
        render("setting/acara/field", $data);
    }

    public function getField() {
        $key['id'] = $this->input->get("id");
        $data = $this->db->get_where("acara_field", $key)->row();
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
        $urutan = $this->app_model->getUrutanAcaraField($_POST['id_acara']);
        if (empty($id)) {
            $data['id_acara_tipe'] = $_POST['id_acara'];
            $data['nama_field'] = $_POST['nama_field'];
            $data['nama_label'] = $_POST['nama_label'];
            $data['type'] = $_POST['jenis_field'];
            $data['ukuran'] = $_POST['deskripsi_field'];
            $data['urutan'] = $urutan;
            // $data['isian'] = $_POST['id_acara'];
            // $data['wajib'] = 1;
            // $data['urutan'] = $_POST['id_acara'];
            $this->db->insert("acara_field", $data);
        } else {
            $key['id'] = $id;
            $data['id_acara_tipe'] = $_POST['id_acara'];
            $data['nama_field'] = $_POST['nama_field'];
            $data['nama_label'] = $_POST['nama_label'];
            $data['type'] = $_POST['jenis_field'];
            $data['ukuran'] = $_POST['deskripsi_field'];
            $this->db->update("acara_field", $data, $key);
        }
        $this->session->set_flashdata('success', 'Berhasil menambah data field');
        $resutl = array(
            "resp_code" => 200
        );
        echo json_encode($resutl);
    }

    public function deleteField() {
        $key['id'] = $this->input->get("id");
        $data = $this->db->delete("acara_field", $key);
////        print_r($data);
//        if ($data != null || !empty($data)) {
//            $respon['resp_code'] = 200;
//            $respon['data'] = $data;
//            echo json_encode($respon);
//            exit();
//        }
        $respon['resp_code'] = 200;
        echo json_encode($respon);
        exit();
    }

    public function saveUrutan() {
        $key['id'] = $_POST['id'];
        $data['urutan'] = $_POST['urutan'];
        $this->db->update('acara_field', $data, $key);
        echo json_encode(array("resp_code" => "200"));
    }

}

/* End of file Acara.php */
/* Location: ./application/controllers/Acara.php */
