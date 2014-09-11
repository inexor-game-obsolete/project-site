<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pgroups_model extends CI_Model {

	private $_table = 'pgroups';

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_group($id) {
		 $query = $this->db->get_where($this->_table, array('id' => $id));
		 return $query->row();
	}

	public function get_group_by_name($name) {
		$query = $this->db->get_where($this->_table, array('name' => $name));
		return $query->row();
	}

	public function get_permissions_by_parent($id) {
		$query = $this->db->get_where('permissions', array('parent' => $id));
		return $query->result_array();
	}


}