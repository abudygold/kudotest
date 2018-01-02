<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->add_package_path(APPPATH.'third_party/ion_auth/');
		$this->load->library(array('ion_auth'));
		$this->load->remove_package_path(APPPATH.'third_party/ion_auth/');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}
	
	public function login() {

		$this->form_validation->set_rules('username', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember))
			{
				$this->session->set_flashdata('message', has_alert( 'success', $this->ion_auth->messages() ) );
				
				//set session menu roles for user by user_id
				$get_group = $this->ion_auth->get_users_groups($this->session->userdata('pengguna_id'))->result_array();
				$this->session->set_userdata('userRoles', $get_group[0]['akses_menu']);
				
				redirect('welcome');
			}
			else
			{
				$this->session->set_flashdata('message', has_alert( 'warning', $this->ion_auth->errors() ) );			
				redirect('auth/login');
			}
		}
		else
		{
			$this->data['message'] = (validation_errors()) ? has_alert('danger', validation_errors()) : has_alert('warning', $this->session->flashdata('message'));

			$this->data['username'] = array('name' => 'username',
				'id'    => 'username',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('username'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);
		
			$contents = $this->load->view('pages/auth/login', $this->data, true);		
			$this->login_render($contents);
		}
	}

	public function logout() {

		$logout = $this->ion_auth->logout();

		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('login');
	}

	public function create_user() {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$tables = $this->config->item('tables','ion_auth');
		$identity_column = $this->config->item('identity','ion_auth');
		$this->data['identity_column'] = $identity_column;
		
		$this->form_validation->set_rules('nama_pertama', $this->lang->line('create_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('nama_terakhir', $this->lang->line('create_user_validation_lname_label'), 'required');
		if($identity_column!=='email')
		{
			$this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['pengguna'].'.'.$identity_column.']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
		}
		else
		{
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['pengguna'] . '.email]');
		}
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
		
		if ($this->form_validation->run() == true)
		{
			$email    = strtolower($this->input->post('email'));
			$identity = strtolower($this->input->post('nama_pertama').' '.$this->input->post('nama_terakhir'));
			$password = $this->input->post('password');

			$additional_data = array(
				'nama_pertama' => $this->input->post('nama_pertama'),
				'nama_terakhir'  => $this->input->post('nama_terakhir'),
				'alamat'    => $this->input->post('alamat'),
				'telpon'      => $this->input->post('telpon'),
				'grup_id'      => $this->input->post('grup_id')
			);
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
		{
			$this_alert = has_alert( 'success', $this->ion_auth->messages() );
		} else {
			$this_alert = (validation_errors() ? has_alert( 'warning', validation_errors() ) : ($this->ion_auth->errors() ? has_alert( 'warning', $this->ion_auth->errors() ) : has_alert( 'success', $this->session->flashdata('message') )));
		}
		
		echo json_encode($this->session->set_flashdata('message', $this_alert));
    }
	
	public function get_user_by_id($id) {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}

		$params = array(
			'select' => 'pengguna.*, grup_pengguna.grup_id, grup_pengguna.grup_id',
			'join' => array('grup_pengguna' => 'grup_pengguna.pengguna_id = pengguna.id'),
			'where' => array('pengguna.id' => $id)
		);
		$data = $this->General_Model->selectData('pengguna', $params);
		
		$temp_group = '';			
		foreach($data->result_array() as $k=>$v) {				
			(!empty($temp_group))? $temp_group = $temp_group.', '.$v['grup_id'] : $temp_group = $v['grup_id'];
		}
		
		$data_unique = array_unique(array_column($data->result_array(), 'username'));
		$data_unique = array_intersect_key($data->result_array(), $data_unique);
		
		$data_unique[0]['grup_id'] = $temp_group;

		echo json_encode($data_unique[0]);
	}

	public function edit_user() {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$id = $this->input->post('id');
		
		$user = $this->ion_auth->user($id)->row();
		
		$this->form_validation->set_rules('nama_pertama', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('nama_terakhir', $this->lang->line('edit_user_validation_lname_label'), 'required');
		
		if ($this->input->post('password'))
		{
			$this->form_validation->set_rules(
				'password',
				$this->lang->line('edit_user_validation_password_label'),
				'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]'
			);
			$this->form_validation->set_rules(
				'password_confirm',
				$this->lang->line('edit_user_validation_password_confirm_label'),
				'required'
			);
		}
		
		if ($this->form_validation->run() === TRUE)
		{
			$identity = strtolower($this->input->post('nama_pertama').' '.$this->input->post('nama_terakhir'));
				
			$data = array(
				'username' => $identity,
				'nama_pertama' => $this->input->post('nama_pertama'),
				'nama_terakhir'  => $this->input->post('nama_terakhir'),
				'alamat'    => $this->input->post('alamat'),
				'telpon'      => $this->input->post('telpon')
			);
			
			if ($this->input->post('password')) {
				$data['password'] = $this->input->post('password');
			}
			
			//Update the groups user belongs to
			$groupData = $this->input->post('grup_id');

			if (isset($groupData) && !empty($groupData)) {
				$this->ion_auth->remove_from_group('', $id);
				$this->ion_auth->add_to_group($groupData, $id);
			}
			
			if($this->ion_auth->update($user->id, $data)) {
				$this_alert = has_alert( 'success', $this->ion_auth->messages() );
			} else {
				$this_alert = has_alert( 'warning', $this->ion_auth->errors() );
			}
		} else {
			$this_alert = has_alert( 'warning', validation_errors() );
		}
		
		echo json_encode($this->session->set_flashdata('message', $this_alert));
	}

	public function activate($id, $code=false) {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$activation = false;
		
		if ($this->ion_auth->logged_in())
			$activation = $this->ion_auth->activate($id);
		
		if ($activation) { $this_alert = has_alert( 'success', $this->ion_auth->messages() ); }
			else { $this_alert = has_alert( 'warning', $this->ion_auth->errors() ); }
		
		echo json_encode($this->session->set_flashdata('message', $this_alert));
	}

	public function deactivate($id = NULL) {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$id = (int) $id;
		
		if ($this->ion_auth->logged_in())
		{	
			$activation = $this->ion_auth->deactivate($id);
			
			if ($activation) { $this_alert = has_alert( 'success', $this->ion_auth->messages() ); }
				else { $this_alert = has_alert( 'warning', $this->ion_auth->errors() ); }
		}
		
		echo json_encode($this->session->set_flashdata('message', $this_alert));
	}

	public function create_group() {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');
		
		if ($this->form_validation->run() == true) {
			
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('group_description'));
			
			if($new_group_id)
				$this_alert = has_alert( 'success', $this->ion_auth->messages() );
		} else {
			$this_alert = has_alert( 'warning', validation_errors() );
		}
		
		echo json_encode($this->session->set_flashdata('message', $this_alert));
	}
	
	public function get_group_by_id($id) {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}

		$params = array(
			'select' => 'grup.id, grup.nama, grup.deskripsi',
			'where' => array('grup.id' => $id)
		);
		$data = $this->General_Model->selectData('grup', $params);
		$data = $data->result_array();

		echo json_encode($data[0]);
	}

	public function edit_group() {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
		
		$id = $this->input->post('id');
		
		$group = $this->ion_auth->group($id)->row();

		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');
		
		if ($this->form_validation->run() === TRUE)
		{
			$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

			if($group_update) {
				$this_alert = has_alert( 'success', $this->lang->line('edit_group_saved') );
			} else {
				$this_alert = has_alert( 'warning', $this->ion_auth->errors() );
			}
		} else {
			$this_alert = (validation_errors() ? has_alert( 'warning', validation_errors() ) : ($this->ion_auth->errors() ? has_alert( 'warning', $this->ion_auth->errors() ) : has_alert( 'success', $this->session->flashdata('message') )));
		}
		
		echo json_encode($this->session->set_flashdata('message', $this_alert));
	}

	public function delete_group($id) {
		
		if(!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}

		$params = array(
			'select' => 'pengguna.*, grup_pengguna.grup_id',
			'join' => array('grup_pengguna' => 'grup_pengguna.pengguna_id = pengguna.id'),
			'where' => array('grup_pengguna.grup_id' => $id)
		);
		$data = $this->General_Model->selectData('pengguna', $params);
		
		if( empty($data) ) {
			
			$params = array( 'where' => array('grup.id' => $id) );
			$this->General_Model->deleteData('grup', $params);
			
			$this_alert = has_alert( 'success', 'Data has been deleted' );
		} else {
			$this_alert = has_alert( 'warning', 'Dont delete this group, because any user active with this group' );
		}

		echo json_encode($this->session->set_flashdata('message', $this_alert));
	}

	public function _get_csrf_nonce() {
		
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce() {
		
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));		
		return  ( $csrfkey && ($csrfkey == $this->session->flashdata('csrfvalue')) )? TRUE : FALSE;
	}
}
