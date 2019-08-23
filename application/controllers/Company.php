<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Company extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $data = array(
            'data' => $this->db->get('company')->result(),
        );
        render('company/data', $data);
    }

    public function add() {
        render('company/form');
    }

    public function save() {
        $post = $_POST;
        $id = $this->input->post("id");
        if (empty($id)) {
            $data['nama'] = $post['nama'];
            $data['alamat'] = $post['alamat'];
            $data['notelp'] = $post['notelp'];
            $data['email'] = $post['email'];
            $data['status'] = 1;
            $path = realpath(APPPATH . '../files/images/');
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
                    'create_thumb' => true,
                    'overwrite' => TRUE
                ));
                if ($this->image_lib->resize()) {
                    $data['logo'] = $data_upload['raw_name'] . $data_upload['file_ext'];
                } else {
                    $data['logo'] = $data_upload['file_name'];
                }
            } else {
                $data['logo'] = "";
            }
            // print_r($data);
            $this->db->insert("company", $data);
            redirect(base_url() . 'Company', 'refresh');
        } else {
            if (isset($_FILES)) {
                $path = realpath(APPPATH . '../files/images/');
                
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
                        $data['logo'] = $data_upload['raw_name'] . $data_upload['file_ext'];
                    } else {
                        $data['logo'] = $data_upload['file_name'];
                    }
                } else {
                    $data['logo'] = "";
                }
            }
            $key['id'] = $id;
            $data['nama'] = $post['nama'];
            $data['alamat'] = $post['alamat'];
            $data['notelp'] = $post['notelp'];
            $data['email'] = $post['email'];
            $this->db->update("company", $data, $key);
            redirect(base_url() . 'Company', 'refresh');
        }
    }

    public function edit() {
        $key['id'] = $this->input->get("id");
        $data = array(
            'data_company' => $this->db->get_where("company", $key)->result(),
        );
        render("company/form", $data);
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['id'] = $id;
        $this->db->delete("company", $key);
        redirect(base_url() . 'Company', 'refresh');
    }

}

/* End of file Company.php */
/* Location: ./application/controllers/Company.php */
