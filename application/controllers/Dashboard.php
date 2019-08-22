<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Dashboard extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    checkToken();
  }

  public function index()
  {
    render('dashboard');
  }

}


/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */