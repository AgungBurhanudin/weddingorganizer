<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $query = "SELECT a.*,b.nama_kategori FROM vendor a LEFT JOIN kategori_vendor b ON a.id_kategori = b.id";
        $data = array(
            'data' => $this->db->query($query)->result(),
        );
        render('vendor/data', $data);
    }

    public function add() {
        $data = array(
            'data_company' => $this->db->get('company')->result(),
            'data_kategori' => $this->db->get('kategori_vendor')->result(),
        );
        render('vendor/form', $data);
    }

    public function save() {
        $post = $_POST;
        $id = $this->input->post("id");
        if (empty($id)) {
            $data['id_kategori'] = $post['kategori'];
            $data['id_company'] = $post['company'];
            $data['vendor'] = $post['vendor'];
            $data['cp'] = $post['cp'];
            $data['nohp_cp'] = $post['nohp_cp'];
            $data['keterangan'] = $post['keterangan'];
            // print_r($data);
            $this->db->insert("vendor", $data);
            redirect(base_url() . 'Vendor', 'refresh');
        } else {
            $key['id'] = $id;
            $data['id_kategori'] = $post['kategori'];
            $data['id_company'] = $post['company'];
            $data['vendor'] = $post['vendor'];
            $data['cp'] = $post['cp'];
            $data['nohp_cp'] = $post['nohp_cp'];
            $data['keterangan'] = $post['keterangan'];
            $this->db->update("vendor", $data, $key);
            redirect(base_url() . 'Vendor', 'refresh');
        }
    }

    public function edit() {
        $key['id'] = $this->input->get("id");
        $data = array(
            'data_vendor' => $this->db->get_where("vendor", $key)->result(),
            'data_company' => $this->db->get('company')->result(),
            'data_kategori' => $this->db->get('kategori_vendor')->result()
        );
        render("vendor/form", $data);
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['id'] = $id;
        $this->db->delete("vendor", $key);
        redirect(base_url() . 'Vendor', 'refresh');
    }

}

/* End of file Vendor.php */
/* Location: ./application/controllers/Vendor.php */