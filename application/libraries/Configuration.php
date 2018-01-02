<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration {
	
	public function __construct() {
		$this->CI = &get_instance();
	}

	function load_menus() {
		
		$arr_menus = array();
		$temp_sess_menus = array();
		
		foreach(unserialize($this->CI->session->userdata('userRoles')) as $key=>$dt) {
			$temp_sess_menus[] = $key;
		}
		
		$this->CI->db->from('akses');
		$this->CI->db->order_by('orders', 'asc');
		$this->CI->db->where('parent_id', 0);
		$this->CI->db->where_in('groups_controller', $temp_sess_menus);	
		$get_menus = $this->CI->db->get();
		
		foreach($get_menus->result() as $key=>$dt) 
		{
			$arr_menus['_menus'][] = array(
				'menu' => $dt->name.';'.$dt->controller.';'.$dt->action.';'.$dt->plugin.';'.$dt->icon,
				'sub_menu' => array()
			);
			
			/* check to get submenu */
			if( count( $this->CI->General_Model->get_parent($dt->menu_id) ) > 0 )
			{
				foreach( $this->CI->General_Model->get_parent($dt->menu_id) as $k=>$d )
				{	
					/* check user roles and data group controller */
					foreach(unserialize($this->CI->session->userdata('userRoles')) as $k2=>$d2)
					{
						foreach($d2 as $k3=>$d3)
						{
							if($d->action === $d3 && $d->groups_controller === strtolower($k2))
							{
								$arr_menus['_menus'][$key]['sub_menu'][] = $d->name.';'.$d->controller.';'.$d->action.';'.$d->plugin.';'.$d->icon;
								break 2;
							}
						}
					}
					
				}
			}
		}
		
		$this->CI->session->set_userdata($arr_menus);
		
		return $arr_menus;
	}

	function load_configs() {
		
		$arr_configs = array();
		
		$this->CI->db->from('konfigurasi');
		$get_configs = $this->CI->db->get();
		
		foreach ($get_configs->result() as $dt) {
			$arr_configs['config'][$dt->judul] = $dt->deskripsi;
		}
		
		$this->CI->session->set_userdata($arr_configs);
		
		return $arr_configs;
	}
	
	function userRole() {
		
		
		$noRoles = 'Terjadi kesalahan pada saat menampilkan menu anda, untuk bantuan silahkan hubungi administrator';
		
		if( $this->CI->session->userdata('userRoles') )
		{
			$data = unserialize( $this->CI->session->userdata('userRoles') );
			
			$noRoles = 'Anda tidak memiliki akses untuk mengakses link tersebut. Terima Kasih';
			
			/* -- Check isset router class -- */
			if (!array_key_exists(ucfirst($this->CI->router->class), $data)) {
				$this->CI->session->set_flashdata('not_allowed_access', $noRoles);
				redirect('welcome');
			}
			
			foreach ($data as $k=>$d)
			{
				/* -- Check isset router method -- */
				if( ucfirst($this->CI->router->class) === $k ) {
					if( !in_array($this->CI->router->method, $d) ) {
						$this->CI->session->set_flashdata('not_allowed_access', $noRoles);
						redirect('welcome');
					}
				}
			}
		} else {
			$this->CI->session->set_flashdata('not_allowed_access', $noRoles);
			redirect('welcome');
		}
	}

	function create_slug($set_config, $title, $string) {
		
		$this->CI->slug->set_config($set_config);

		$data = array($title => $string);
		$uri_slug = $this->CI->slug->create_uri($data);
		
		return $uri_slug;
	}

	function save_history() {
		
		$this->db2 = $this->CI->load->database('history', TRUE);
		
		$history_data = array(
		    'event'   	=> $this->CI->db->last_query(),
		    'date'   	=> date('Y-m-d H:i:s'),
	    	//'user'      => $this->session->userdata('email'),
		);
		
		$this->db2->insert('tabel_history', $history_data);
	}

	// public function get_hashed_password($username) {

 //    	$user = $this->CI->db->select('password, email')->where('email', $username)->get('users');

 //        if ($user->num_rows() == 0) {
 //            return false;
 //        }

 //        // $user_details = $user->row();
 //        // $HA1 = $user_details->email;

 //        return true;
 //    }

}