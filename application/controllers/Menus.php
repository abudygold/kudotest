<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends MY_Controller {

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
		
		$temp_parent_id = array('' => '--- Select Parent ID ---');		
		
		$customWhere = array(
			'select' => '*',
			'where' => array(
				'parent_id' => '0'
			),
			'order_by' => 'orders ASC'
		);
		
		$parent_id = $this->General_Model->selectData('akses', $customWhere);
		
		if($parent_id) {
			foreach ($parent_id->result() as $parentid) {
				$temp_parent_id[$parentid->menu_id] = $parentid->name;
			}
		}

		$data['temp_parent_id'] = $temp_parent_id;
		$data['get_menus'] = $this->General_Model->selectData('akses', $customWhere);
		
		$contents = $this->load->view('pages/menus/index', $data, true);
		$this->app_render($contents);
	}

	public function editData($id) {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}		
		
		$conditions = array(
			'where' => array(
				'menu_id' => $id
			)
		);
		$data = $this->General_Model->selectData('akses', $conditions);
		
		echo json_encode( $data->row() );
	}

	public function addData() {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}
		
		$this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('controller', 'controller', 'required');
		$this->form_validation->set_rules('icon', 'icon', 'required');
		$this->form_validation->set_rules('orders', 'orders', 'required');

		if ($this->form_validation->run() == true)
		{
			($this->input->post('controller') !== '#')? $groups_controller = $this->input->post('controller') : $groups_controller = $this->input->post('action');
			
			$data = array(
				'name' => $this->input->post('name'),
				'controller' => $this->input->post('controller'),
				'action' => $this->input->post('action'),
				'plugin' => $this->input->post('plugin'),
				'icon' => $this->input->post('icon'),
				'parent_id' => $this->input->post('parent_id'),
				'orders' => $this->input->post('orders'),
				'groups_controller' => $groups_controller
			);
				
			$this->General_Model->insertData('akses', $data);
			
			echo json_encode(array("status" => TRUE));
		} else {
			echo json_encode(validation_errors());
		}
		
	}

	public function updateData() {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}
		
		$this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('controller', 'controller', 'required');
		$this->form_validation->set_rules('icon', 'icon', 'required');
		$this->form_validation->set_rules('orders', 'orders', 'required');

		if ($this->form_validation->run() == true)
		{	
			($this->input->post('controller') !== '#')? $groups_controller = $this->input->post('controller') : $groups_controller = $this->input->post('action');
			
			$data = array(
				'name' => $this->input->post('name'),
				'controller' => $this->input->post('controller'),
				'action' => $this->input->post('action'),
				'plugin' => $this->input->post('plugin'),
				'icon' => $this->input->post('icon'),
				'parent_id' => $this->input->post('parent_id'),
				'orders' => $this->input->post('orders'),
				'groups_controller' => $groups_controller
			);			
			$conditions = array(
				'where' => array('menu_id' => $this->input->post('menu_id'))
			);
			
			$this->General_Model->updateData('akses', $data, $conditions);
			
			echo json_encode(array("status" => TRUE));
		} else {
			echo json_encode(validation_errors());
		}
	}

	public function deleteData($id) {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}
		
		$conditions = array( 'where' => array( 'menu_id' => $id ) );
		$parent_id = $this->General_Model->deleteData('akses', $conditions);
		
		echo json_encode(array("status" => TRUE));
	}

	public function bulkDelete($id) {

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}
		
		$conditions = array( 'where' => array( 'parent_id' => $id ) );
		$this->General_Model->deleteData('akses', $conditions);
		
		$conditions = array( 'where' => array( 'menu_id' => $id ) );		
		$this->General_Model->deleteData('akses', $conditions);
		
		echo json_encode(array("status" => TRUE));
	}
	
}
