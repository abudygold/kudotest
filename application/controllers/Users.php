<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	var $table = 'pengguna';
    var $column = array(null, 'username','email','dibuat_tgl','terakhir_login');
    var $search = array('username','email','dibuat_tgl','terakhir_login'); 
    var $order = array('username' => 'DESC');
	
	public function __construct() {
		
		parent::__construct();
		
		$this->load->add_package_path(APPPATH.'third_party/ion_auth/');
		$this->load->library(array('ion_auth'));
		$this->load->remove_package_path(APPPATH.'third_party/ion_auth/');
		
		$this->load->model('Datatables_Model');
	}
	
	public function index() {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$tempGrup = array();
		$custom = array( 'select' => 'id, nama' );
		$dataGrup = $this->General_Model->selectData('grup', $custom);
		foreach($dataGrup->result() as $k=>$v) {
			$tempGrup[ $v->id ] = ucwords($v->nama);
		}
		$data['dataGrup'] = $tempGrup;
			
		$contents = $this->load->view('pages/auth/index', $data, true);
		$this->app_render($contents);
	}
	
	public function getDataUser() {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$conditions = $like = array();
		
		if( !empty($this->input->post('email')) )
			$conditions['email'] = $this->input->post('email');
		if( !empty($this->input->post('username')) )
			$like['username'] = $this->input->post('username');
		
        $data = $this->Datatables_Model->get_data($this->table, $this->column, $this->search, $this->order, $conditions, null, $like);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Datatables_Model->count_all($this->table, $conditions, null, $like),
            "recordsFiltered" => $this->Datatables_Model->count_filtered($this->table, $this->column, $this->search, $this->order, $conditions, null, $like),
            "data" => $data
        );
		
		echo json_encode($output);
    }
}
