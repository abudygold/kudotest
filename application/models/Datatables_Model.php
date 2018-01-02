<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatables_Model extends CI_Model {

    public function __construct() {
    	
        parent::__construct();
		
		date_default_timezone_set('Asia/Jakarta');
    }

    private function _get_datatables_query($set_table, $set_column, $set_search, $set_order, $set_where='', $set_join='', $set_like='', $set_select='') {
		
		$this->db->select($set_select);    	
		$this->db->from($set_table);
		
		if($set_where != '')
			$this->db->where($set_where);
		
		if($set_like != '') {
			foreach($set_like as $k=>$d) {
				$this->db->like($k, $d);
			}
		}
		
		if($set_join != '') {
			foreach ($set_join as $key=>$value) {
				$this->db->join(''.$key.'', ''.$value.'');
			}
		}
		
        $i = 0;
		
        foreach ($set_search as $item)
        {
            if($_POST['search']['value']) {
				if($i===0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
	
				if(count($set_search) - 1 == $i)
					$this->db->group_end();
			}
        	$i++;
        }
        
		if(isset($_POST['order'])) {
        	$this->db->order_by($set_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($set_order)) {
        	$order = $set_order;
        	$this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_data($set_table, $set_column, $set_search, $set_order, $set_where='', $set_join='', $set_like='', $set_select='') {
    	
        $this->_get_datatables_query($set_table, $set_column, $set_search, $set_order, $set_where, $set_join, $set_like, $set_select);
		
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($set_table, $set_column, $set_search, $set_order, $set_where='', $set_join='', $set_like='', $set_select='') {
    	
        $this->_get_datatables_query($set_table, $set_column, $set_search, $set_order, $set_where, $set_join, $set_like, $set_select);
        
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($set_table, $set_where='', $set_join='', $set_like='', $set_select='') {
		
		$this->db->select($set_select);    	
        $this->db->from($set_table);
		
		if($set_where != '')
			$this->db->where($set_where);
		
		if($set_like != '') {
			foreach($set_like as $k=>$d) {
				$this->db->like($k, $d);
			}
		}
		
		if($set_join != '') {
			foreach ($set_join as $key=>$value) {
				$this->db->join($key, $value);
			}
		}
		
        return $this->db->count_all_results();
    }

}