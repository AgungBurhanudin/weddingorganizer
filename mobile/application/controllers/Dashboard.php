<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // checkToken();
    }

    public function index() {
        render('dashboard');
    }
    
    public function biodata() {
        render('biodata');
    }
    
    public function meeting() {
        render('meeting');
    }
    
    public function vendor() {
        render('vendor');
    }
    
    public function payment() {
        render('payment');
    }
    
    public function contactus() {
        render('contactus');
    }
    
    public function layout() {
        render('layout');
    }

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */