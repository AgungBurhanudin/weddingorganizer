<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{		
    redirect(base_url() . "Login",'refresh');    
	}
}
