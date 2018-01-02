<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->add_package_path(APPPATH.'third_party/ion_auth/');
		$this->load->library(array('ion_auth'));
		$this->load->remove_package_path(APPPATH.'third_party/ion_auth/');
	}
	
	public function view($id) {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$custom = array(
			'select' => 'id, nama_pertama, nama_terakhir, alamat, telpon',
			'where' => array('id' => $id),
			'limit' => 1
		);
		$dataPengguna = $this->General_Model->selectData('pengguna', $custom);
		$dataPengguna = $dataPengguna->result();
		$data['dataPengguna'] = $dataPengguna[0];
			
		$contents = $this->load->view('pages/auth/edit_user', $data, true);
		$this->app_render($contents);
	}
}
