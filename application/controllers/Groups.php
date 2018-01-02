<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends MY_Controller {
	
	var $table = 'grup';
    var $column = array(null, 'name','description');
    var $search = array('name','description');
    var $order = array('name' => 'DESC');
	
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
		
		$contents = $this->load->view('pages/auth/indexGroup', null, true);		
		$this->app_render($contents);
	}
	
	public function getDataGroup() {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$like = array();
		
		if( !empty($this->input->post('group_name')) )
			$like['name'] = $this->input->post('group_name');
		
        $data = $this->Datatables_Model->get_data($this->table, $this->column, $this->search, $this->order, null, null, $like);

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Datatables_Model->count_all($this->table, null, null, $like),
            "recordsFiltered" => $this->Datatables_Model->count_filtered($this->table, $this->column, $this->search, $this->order, null, null, $like),
            "data" => $data
        );
		
		echo json_encode($output);
    }
}
