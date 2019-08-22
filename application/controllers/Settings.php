<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        render("settings");
    }

    public function dokumen() {
        $key['setting_key'] = 'template_dokumen';
        $data = array(
            'dokumen' => $this->db->get_where('app_setting', $key)->row()
        );
        render("setting/template", $data);
    }

    public function saveTemplate() {
        if (isset($_FILES)) {
            $path = realpath(APPPATH . '../files/template/');

            $this->upload->initialize(array(
                'upload_path' => $path,
                'allowed_types' => 'xlsx'
            ));

            if ($this->upload->do_upload()) {
                $data_upload = $this->upload->data();
                $data['setting_value'] = $data_upload['file_name'];
            } else {
                $data['setting_value'] = "";
            }
        }
        $key['setting_key'] = "template_dokumen";
        $this->db->update('app_setting', $data, $key);
        $this->session->set_flashdata('success', 'Berhasil mengupload template dokumen');
        redirect(base_url() . 'Settings/dokumen', 'refresh');
    }

}

/* End of file Settings.php */
/* Location: ./application/controllers/Settings.php */
