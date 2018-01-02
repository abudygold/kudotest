<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configurations extends MY_Controller {
	
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
		
		$conditions = array('select' => '*');
		$data['data'] = $this->General_Model->selectData('konfigurasi', $conditions);
		
		$contents = $this->load->view('pages/configurations/index', $data, true);		
		$this->app_render($contents);
	}
	
	public function add()  {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		//$this->form_validation->set_rules('logo', 'Logo', 'required');
	    //$this->form_validation->set_rules('favicon', 'Favicon', 'required');
		$this->form_validation->set_rules('app_name', 'App Name', 'required');
	
	    if ($this->form_validation->run() === TRUE) {
			
			$arr_configs = array();
	    	$arr_input = $this->input->post();
			
			$get_configs = $this->General_Model->selectData('konfigurasi');
			
			if($get_configs)
			{
				foreach ($get_configs->result() as $dt)
				{
					$arr_configs[$dt->judul] = $dt->deskripsi;
				}
			}

			foreach($arr_input as $key=>$value)
			{
				if(array_key_exists($key, $arr_configs))
				{
					$data = array(
						'judul' => $key,
						'deskripsi' => $value
					);
					$conditions = array(
						'where' => array('judul' => $key)
					);
					$this->General_Model->updateData('konfigurasi', $data, $conditions);
				}
				else
				{
					$data = array(
						'judul' => $key,
						'deskripsi' => $value
					);
					$this->General_Model->insertData('konfigurasi', $data);
				}
			}
	    } else {			
			$this_alert = has_alert( 'warning', validation_errors() );
			$this->session->set_flashdata('message', $this_alert);
	    }
		
		redirect('configurations');
	}
	
}
