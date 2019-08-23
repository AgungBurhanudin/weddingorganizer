<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Wedding extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Wedding_model')
    checkToken();
  }

  public function index()
  {
    render('wedding/data');
  }

  public function add()
  {
    render('wedding/add');
    if($this->input->post('finish')){
      $this->form_validation->set_rules('title', 'Judul', 'trim|required');
      $this->form_validation->set_rules('pengantin_pria', 'Pengantin Pria', 'trim|required');
      $this->form_validation->set_rules('pengantin_wanita', 'Pengantin Wanita', 'trim|required');
      $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
      $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
      $this->form_validation->set_rules('tempat', 'Tempat', 'trim|required');
      $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
      $this->form_validation->set_rules('tema', 'Tema', 'trim|required');
      $this->form_validation->set_rules('hashtag', 'Hashtag', 'trim|required');
      $this->form_validation->set_rules('penyelenggara', 'Penyelenggara', 'trim|required');
      $this->form_validation->set_rules('undangan', 'Undangan', 'trim|required');
      $this->form_validation->set_rules('status', 'Status', 'trim|required');
    }
  }

  public function form()
  {
    render('wedding/form');
  }

}


/* End of file Wedding.php */
/* Location: ./application/controllers/Wedding.php */