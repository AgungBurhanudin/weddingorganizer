<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Panitia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $key = "WHERE 1 = 1 ";
        if (isset($_GET['nama_panitia'])) {
            $key .= "AND nama_panitia LIKE '%" . $_GET['nama_panitia'] . "%'";
        }
        $data = array(
            'panitia_tipe' => $this->db->get("panitia_tipe")->result(),
            'key' => $_GET
        );
        render('setting/panitia/data', $data);
    }

    public function add() {
        $key['id'] = "";
        $data = array(
            'panitia_tipe' => $this->db->get_where("panitia_tipe", $key)->result(),
        );
        render('setting/panitia/form', $data);
    }

    public function edit() {
        $key['id'] = $this->input->get("id");
        $data = array(
            'panitia_tipe' => $this->db->get_where("panitia_tipe", $key)->result(),
        );
        render("setting/panitia/form", $data);
    }

    public function simpan() {
        $id = $this->input->post("id");
        if (empty($id)) {
            $data = $_POST;
            $this->db->insert("panitia_tipe", $data);
            redirect(base_url() . 'Setting/Panitia');
        } else {
            $key['id'] = $id;
            $data = $_POST;
            $this->db->update("panitia_tipe", $data, $key);
            redirect(base_url() . 'Setting/Panitia');
        }
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['id'] = $id;
        $this->db->delete("panitia_tipe", $key);
        redirect(base_url() . 'Setting/Panitia');
    }

    public function field() {
        $key['id'] = $this->input->get("id");
        $key2['id_panitia_tipe'] = $this->input->get("id");
        $this->db->order_by("urutan", "asc");
        $acara_field = $this->db->get_where("panitia_field", $key2)->result();
        $data = array(
            'panitia_tipe' => $this->db->get_where("panitia_tipe", $key)->row(),
            'panitia_field' => $acara_field,
        );
        render("setting/panitia/field", $data);
    }

    public function getField() {
        $key['id'] = $this->input->get("id");
        $data = $this->db->get_where("panitia_field", $key)->row();
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
        $urutan = $this->app_model->getUrutanPanitiaField($_POST['id_panitia']);
        if (empty($id)) {
            $data['id_panitia_tipe'] = $_POST['id_panitia'];
            $data['nama_field'] = $_POST['nama_field'];
            $data['nama_label'] = $_POST['nama_label'];
            $data['type'] = $_POST['jenis_field'];
            $data['ukuran'] = $_POST['deskripsi_field'];
            $data['urutan'] = $urutan;
            // $data['isian'] = $_POST['id_panitia'];
            // $data['wajib'] = 1;
            // $data['urutan'] = $_POST['id_panitia'];
            $this->db->insert("panitia_field", $data);
        } else {
            $key['id'] = $id;
            $data['id_panitia_tipe'] = $_POST['id_panitia'];
            $data['nama_field'] = $_POST['nama_field'];
            $data['nama_label'] = $_POST['nama_label'];
            $data['type'] = $_POST['jenis_field'];
            $data['ukuran'] = $_POST['deskripsi_field'];
            $this->db->update("panitia_field", $data, $key);
        }
        $this->session->set_flashdata('success', 'Berhasil menambah data field');
        $resutl = array(
            "resp_code" => 200
        );
        echo json_encode($resutl);
    }

    public function deleteField() {
        $key['id'] = $this->input->get("id");
        $data = $this->db->delete("panitia_field", $key);
        $respon['resp_code'] = 200;
        echo json_encode($respon);
        exit();
    }

    public function saveUrutan() {
        $key['id'] = $_POST['id'];
        $data['urutan'] = $_POST['urutan'];
        $this->db->update('panitia_field', $data, $key);
        echo json_encode(array("resp_code" => "200"));
    }

}

/* End of file Panitia.php */
/* Location: ./application/controllers/Panitia.php */
