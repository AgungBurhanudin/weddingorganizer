<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller {

    public $auth;
    public $group;
    public $id_company;
    public $id_wedding;
    public $id_user;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('wedding_model'));
        $this->auth = $this->session->userdata('auth');
        $this->group = $this->auth['group'];
        $this->id_company = $this->auth['company'];
        $this->id_wedding = $this->auth['id_wedding'];
        $this->id_user = $this->auth['noid'];
        checkToken();
    }

    public function index() {
        $query = "SELECT a.*,b.nama_kategori FROM user a LEFT JOIN kategori_user b ON a.id_kategori = b.id";
        $data = array(
            'data' => $this->db->get('app_user')->result(),
        );
        render('user/data', $data);
    }

    public function add() {
        $data = array(
            'data_company' => $this->db->get('company')->result(),
            'app_group' => $this->db->get('app_group')->result(),
        );
        render('user/form', $data);
    }

    public function save() {
        $post = $_POST;
        $id = $this->input->post("id");

//        $data['user_group_id'] = $post['user_group'];
//        $data['user_company'] = $post['user_company'];
        $data['user_real_name'] = $post['user_real_name'];
        $data['user_user_name'] = $post['user_user_name'];
//        $data['user_password'] = md5($post['password']);
        $data['user_phone'] = $post['user_phone'];
        $data['user_email'] = $post['user_email'];
        $data['user_address'] = $post['user_address'];
        $data['user_desc'] = $post['user_desc'];
        if (isset($_FILES)) {
            $path = realpath(APPPATH . '../files/foto/');

            $this->upload->initialize(array(
                'upload_path' => $path,
                'allowed_types' => 'png|jpg|gif',
                'max_size' => '5000',
                'max_width' => '3000',
                'max_height' => '3000'
            ));

            if ($this->upload->do_upload()) {
                $data_upload = $this->upload->data();
                $this->image_lib->initialize(array(
                    'image_library' => 'gd2',
                    'source_image' => $path . '/' . $data_upload['file_name'],
                    'maintain_ratio' => false,
                    //  'create_thumb' => true,
                    'overwrite' => TRUE
                ));
                if ($this->image_lib->resize()) {
                    $data['user_foto'] = $data_upload['raw_name'] . $data_upload['file_ext'];
                } else {
                    $data['user_foto'] = $data_upload['file_name'];
                }
            } else {
                $data['user_foto'] = "";
            }
        }
        if (empty($id)) {
            // print_r($data);
            $this->db->insert("app_user", $data);
            $msg = "Berhasil menambah user";
        } else {
            $key['user_id'] = $id;
            $this->db->update("app_user", $data, $key);
            $msg = "Berhasil merubah user";
        }
        $this->session->set_flashdata('success', $msg);
        redirect(base_url() . 'User/edit');
    }

    public function savePassword() {
        $post = $_POST;
        $id = $this->input->post("id");
        $data['user_password'] = md5($post['password']);
        $key['user_id'] = $id;
        $this->db->update("app_user", $data, $key);
        $this->session->set_flashdata('success', $msg);
        redirect(base_url() . 'User/edit');
    }

    public function edit() {
        $key['user_id'] = $this->id_user;
        $data = array(
            'data_user' => $this->db->get_where("app_user", $key)->result(),
            'data_company' => $this->db->get('company')->result(),
            'app_group' => $this->db->get('app_group')->result(),
        );
        render("user/form", $data);
    }

    public function password() {
        $key['user_id'] = $this->id_user;
        $data = array(
            'data_user' => $this->db->get_where("app_user", $key)->result(),
            'data_company' => $this->db->get('company')->result(),
            'app_group' => $this->db->get('app_group')->result(),
        );
        render("user/password", $data);
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['user_id'] = $id;
        $this->db->delete("user", $key);
        redirect(base_url() . 'User', 'refresh');
    }

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */