<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General_Model extends CI_Model {
	
    function __construct() {
		
        parent::__construct();
		
		date_default_timezone_set('Asia/Jakarta');
    }
	
	/* Select Column Tabel */
	function list_fields_db($table) {
		
		$columns = $this->db->list_fields($table);		
		return $columns;
	}
	
	/* Select Data */
	function selectData($table, $custom='') {
		
		/*
		 * ('title, content, date') -- select
		 * DISTINCT(reg.registration_id) -- in select
		 * ('age', 'member_age') -- select with as
		 * ('name' => $name, 'title' => $title, 'status' => $status) -- where
		 * ('name' => array('Frank', 'Todd', 'James')) -- where_in
		 * ('title DESC, name ASC') -- order_by (ASC, DESC, RANDOM)
		 * */
				
		if($custom !== ''):
			foreach($custom as $key=>$value):
				
				if($key === 'select'):
					$this->db->select($value);
					
				elseif($key === 'select_max'):
					$this->db->select_max($value);
					
				elseif($key === 'select_min'):
					$this->db->select_min($value);
					
				elseif($key === 'select_avg'):
					$this->db->select_avg($value);
					
				elseif($key === 'select_sum'):
					$this->db->select_sum($value);
					
				elseif($key === 'limit'):
					$this->db->limit($value);
					
				elseif($key === 'join'):
					
					foreach($value as $key2=>$value2):
						$this->db->join($key2, $value2);						
					endforeach;
					
				elseif($key === 'where'):
					
					$this->db->where($value);
					
				elseif($key === 'or_where'):
					
					foreach($value as $key2=>$value2):
						$this->db->or_where($key2, $value2);
					endforeach;
					
				elseif($key === 'where_in'):
					
					foreach($value as $key2=>$value2):
						$this->db->where_in($key2, $value2);
					endforeach;
					
				elseif($key === 'or_where_in'):
					
					foreach($value as $key2=>$value2):
						$this->db->or_where_in($key2, $value2);
					endforeach;
					
				elseif($key === 'where_not_in'):
					
					foreach($value as $key2=>$value2):
						$this->db->where_not_in($key2, $value2);	
					endforeach;
					
				elseif($key === 'or_where_not_in'):
					
					foreach($value as $key2=>$value2):
						$this->db->or_where_not_in($key2, $value2);
					endforeach;
					
				elseif($key === 'like'):
					
					foreach($value as $key2=>$value2):
						$this->db->like($key2, $value2);
					endforeach;
					
				elseif($key === 'not_like'):
					
					foreach($value as $key2=>$value2):
						$this->db->not_like($key2, $value2);
					endforeach;
					
				elseif($key === 'group_by'):
					
					(is_array($value))? $this->db->group_by($value) : $this->db->group_by($value);
					
				elseif($key === 'order_by'):
					
					$this->db->order_by($value);
					
				endif;
					
			endforeach;
		endif;
		
		$query = $this->db->get($table);
		
		if($query->num_rows() > 0): 
			return $query;
		endif;
			
		return false;
	}

	function insertData($table, $data, $is_batch=false) {
		
		/* if($this->session->userdata('email')) {
			$data['created'] = date('Y-m-d h:i:s');
			$data['created_by'] = $this->session->userdata('email');
		} */
		
		($is_batch !== false)? 
			$query = $this->db->insert_batch($table, $data) : $query = $this->db->insert($table, $data);
		
		if($query):
			//$this->configs->save_history();
			return true;
		endif;
		
		return false;
	}
	
	function updateData($table, $data, $custom='', $upd_batch='', $is_batch=false) {
		
		/* if($this->session->userdata('email')) {
			$data['modified'] = date('Y-m-d h:i:s');
			$data['modified_by'] = $this->session->userdata('email');
		} */

		if($custom !== ''):
			foreach($custom as $key=>$value):
				
				if($key === 'where'):
					
					(is_array($value))? $this->db->where($value) : $this->db->where($value);
					
				elseif($key === 'or_where'):
					
					foreach($value as $key2=>$value2):
						$this->db->or_where($key2, $value2);
					endforeach;
					
				elseif($key === 'where_in'):
					
					foreach($value as $key2=>$value2):
						$this->db->where_in($key2, $value2);
					endforeach;
					
				elseif($key === 'like'):
					
					foreach($value as $key2=>$value2):
						$this->db->like($key2, $value2);
					endforeach;
					
				elseif($key === 'not_like'):
					
					foreach($value as $key2=>$value2):
						$this->db->not_like($key2, $value2);
					endforeach;
					
				endif;
					
			endforeach;
		endif;
		
		($is_batch !== false)? 
			$query = $this->db->update_batch($table, $data, $upd_batch) : $query = $this->db->update($table, $data);

		if($query):
			//$this->configs->save_history();
			return true;
		endif;
		
		return false;
	}
	
	function deleteData($table, $custom='') {
		
		/*
		 * ('table1', 'table2', 'table3') -- if you would like to delete data from more than 1 table.
		 */
				
		if($custom !== ''):
			foreach($custom as $key=>$value):
				
				if($key === 'where'):
					
					(is_array($value))? $this->db->where($value) : $this->db->where($value);
					
				elseif($key === 'or_where'):
					
					foreach($value as $key2=>$value2):
						$this->db->or_where($key2, $value2);
					endforeach;
					
				elseif($key === 'where_in'):
					
					foreach($value as $key2=>$value2):
						$this->db->where_in($key2, $value2);
					endforeach;
					
				elseif($key === 'like'):
					
					foreach($value as $key2=>$value2):
						$this->db->like($key2, $value2);
					endforeach;
					
				elseif($key === 'not_like'):
					
					foreach($value as $key2=>$value2):
						$this->db->not_like($key2, $value2);
					endforeach;
					
				endif;
					
			endforeach;
		endif;
		
		$query = $this->db->delete($table);

		if($query):
			//$this->configs->save_history();
			return true;
		endif;
		
		return false;
	}

	function countData($table, $custom='') {
		
		$this->db->from($table);
		
		if($custom !== ''):
			foreach($custom as $key=>$value):
				
				if($key === 'where'):
					
					(is_array($value))? $this->db->where($value) : $this->db->where($value);
					
				elseif($key === 'or_where'):
					
					foreach($value as $key2=>$value2):
						$this->db->or_where($key2, $value2);
					endforeach;
					
				elseif($key === 'where_in'):
					
					foreach($value as $key2=>$value2):
						$this->db->where_in($key2, $value2);
					endforeach;
					
				elseif($key === 'or_where_in'):
					
					foreach($value as $key2=>$value2):
						$this->db->or_where_in($key2, $value2);
					endforeach;
					
				elseif($key === 'where_not_in'):
					
					foreach($value as $key2=>$value2):
						$this->db->where_not_in($key2, $value2);
					endforeach;
					
				elseif($key === 'or_where_not_in'):
					
					foreach($value as $key2=>$value2):
						$this->db->or_where_not_in($key2, $value2);
					endforeach;
					
				elseif($key === 'like'):
					
					foreach($value as $key2=>$value2):
						$this->db->like($key2, $value2);
					endforeach;
					
				elseif($key === 'not_like'):
					
					foreach($value as $key2=>$value2):
						$this->db->not_like($key2, $value2);
					endforeach;
					
				elseif($key === 'order_by'):
					
					$this->db->order_by($value);
					
				endif;
					
			endforeach;
		endif;
		
		return $this->db->count_all_results();
	}
	
	function truncateData($table) {
		
		$query = $this->db->empty_table($table);

		if($query):
			//$this->configs->save_history();
			return true;
		endif;
		
		return false;
	}
	
	function countColumn($table, $select, $where='') {
		
		if($where !== '') {
			foreach ($where as $key=>$value) {
				$this->db->where($key, $value);
			}
		}
		
		$this->db->select_sum($select);
	    $query = $this->db->get($table);

		$data = $query->row();
		
		return $data->$select;
	}
	
	public function getKodeSuffix($table, $suffix, $id, $is_rand=false) {

		/*
		* Generate Code ID, Ex : PT-1621-00001
		*/
		
		if($is_rand !== false):
			$suffix .= date("ymh");
			$suffix .= '0';
		else:
			$suffix .= date("-ym-");
		endif;	
		
		$this->db->select($id);
		$this->db->order_by($id, "desc");
		$query = $this->db->get($table, 1, 0);
		
		if($query->num_rows() > 0):			
			$row = $query->row();
			$suffix .= str_pad(intval(substr($row->$id, -5) + 1), 5, "0", STR_PAD_LEFT);
			return $suffix;	
			
		else:			
			$suffix .= '00001';
			return $suffix;			
		endif;
	}	

	function get_parent($id) {
		
		$this->db->where('parent_id', $id);
		$this->db->order_by('orders', 'ASC');
		return $this->db->get('akses')->result();
	}

}