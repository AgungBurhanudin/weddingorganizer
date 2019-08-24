<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Wedding extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('wedding_model');
    $this->load->library('form_validation');
    checkToken();
  }

  public function index()
  {
    $data['wedding'] = $this->wedding_model->getDataAll();
    render('wedding/data', $data);
  }

  public function add()
  {
    $wedding = $this->wedding_model;
    $validation = $this->form_validation;
    $validation->set_rules($wedding->rules());
    if ($validation->run()) {
      $wedding->insert();
      $this->session->set_flashdata('success', 'Berhasil Ditambahkan');
    }
    $this->load->view('wedding/add');
  }
}


/* End of file Wedding.php */
/* Location: ./application/controllers/Wedding.php */
