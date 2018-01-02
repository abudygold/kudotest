<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->add_package_path(APPPATH.'third_party/ion_auth/');
		$this->load->library(array('ion_auth'));
		$this->load->remove_package_path(APPPATH.'third_party/ion_auth/');
	}
	
	public function index() {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$params = array('select' => '*');
		$data['groups'] = $this->General_Model->selectData('grup', $params);
		
		$contents = $this->load->view('pages/roles/index', $data, true);
		$this->app_render($contents);
	}

	public function add() {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		foreach ($this->input->post() as $key => $value) {
			
			$data = array( 'akses_menu' => serialize($value) );		
			$customWhere = array( 'where' => array('nama' => $key) );
			
			$this->General_Model->updateData('grup', $data, $customWhere);
		}
		
		redirect('roles');
	}
}