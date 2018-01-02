<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->add_package_path(APPPATH.'third_party/ion_auth/');
		$this->load->library(array('ion_auth'));
		$this->load->remove_package_path(APPPATH.'third_party/ion_auth/');
	}
	
	public function index() {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$contents = $this->load->view('pages/index', null, true);		
		$this->app_render($contents);
	}
}
