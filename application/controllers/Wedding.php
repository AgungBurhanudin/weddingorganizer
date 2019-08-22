<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Wedding extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    checkToken();
  }

  public function index()
  {
    render('wedding/data');
  }

  public function add()
  {
    render('wedding/add');
  }

  public function form()
  {
    render('wedding/form');
  }

}


/* End of file Wedding.php */
/* Location: ./application/controllers/Wedding.php */