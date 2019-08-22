<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tambahan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $key = "WHERE 1 = 1 ";
        if (isset($_GET['nama_tambahan_paket'])) {
            $key .= "AND nama_tambahan_paket LIKE '%" . $_GET['nama_tambahan_paket'] . "%'";
        }
        $data = array(
            'tambahan_tipe' => $this->db->query("SELECT * FROM tambahan_tipe $key")->result(),
            'key' => $_GET
        );
        render('setting/tambahan/data', $data);
    }

    public function add() {
        $key['id'] = "";
        $data = array(
            'tambahan_tipe' => $this->db->get_where("tambahan_tipe", $key)->result(),
        );
        render('setting/tambahan/form', $data);
    }

    public function edit() {
        $key['id'] = $this->input->get("id");
        $data = array(
            'tambahan_tipe' => $this->db->get_where("tambahan_tipe", $key)->result(),
        );
        render("setting/tambahan/form", $data);
    }

    public function simpan() {
        $id = $this->input->post("id");
        if (empty($id)) {
            $data = $_POST;
            $this->db->insert("tambahan_tipe", $data);
            redirect(base_url() . 'Setting/Tambahan');
        } else {
            $key['id'] = $id;
            $data = $_POST;
            $this->db->update("tambahan_tipe", $data, $key);
            redirect(base_url() . 'Setting/Tambahan');
        }
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['id'] = $id;
        $this->db->delete("tambahan_tipe", $key);
        redirect(base_url() . 'Setting/Tambahan');
    }

    public function field() {
        $key['id'] = $this->input->get("id");
        $key2['id_tambahan_tipe'] = $this->input->get("id");
        $this->db->order_by("urutan", "asc");
        $tambahan_field = $this->db->get_where("tambahan_field", $key2)->result();
        $data = array(
            'tambahan_tipe' => $this->db->get_where("tambahan_tipe", $key)->row(),
            'tambahan_field' => $tambahan_field,
        );
        render("setting/tambahan/field", $data);
    }

    public function getField() {
        $key['id'] = $this->input->get("id");
        $data = $this->db->get_where("tambahan_field", $key)->row();
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
        $urutan = $this->app_model->getUrutanTambahanField($_POST['id_tambahan']);
        if (empty($id)) {
            $data['id_tambahan_tipe'] = $_POST['id_tambahan'];
            $data['nama_field'] = $_POST['nama_field'];
            $data['nama_label'] = $_POST['nama_label'];
            $data['type'] = $_POST['jenis_field'];
            $data['ukuran'] = $_POST['deskripsi_field'];
            $data['urutan'] = $urutan;
            // $data['isian'] = $_POST['id_tambahan'];
            // $data['wajib'] = 1;
            // $data['urutan'] = $_POST['id_tambahan'];
            $this->db->insert("tambahan_field", $data);
        } else {
            $key['id'] = $id;
            $data['id_tambahan_tipe'] = $_POST['id_tambahan'];
            $data['nama_field'] = $_POST['nama_field'];
            $data['nama_label'] = $_POST['nama_label'];
            $data['type'] = $_POST['jenis_field'];
            $data['ukuran'] = $_POST['deskripsi_field'];
            $this->db->update("tambahan_field", $data, $key);
        }
        $this->session->set_flashdata('success', 'Berhasil menambah data field');
        $resutl = array(
            "resp_code" => 200
        );
        echo json_encode($resutl);
    }

    public function deleteField() {
        $key['id'] = $this->input->get("id");
        $data = $this->db->delete("tambahan_field", $key);
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
        $this->db->update('tambahan_field', $data, $key);
        echo json_encode(array("resp_code" => "200"));
    }

}

/* End of file Acara.php */
/* Location: ./application/controllers/Acara.php */
