<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Users_model extends CI_Model {
	private $_table = 'users';
	private $_hash_algos = array('whirlpool', 'sha512');

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


	public function user($id) {
		$this->db->where('id', $id);
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	public function user_by_username($username) {
		$this->db->where('username', $username);
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	public function user_by_unique_id($unique_id) {
		$this->db->where('unique_id', $unique_id);
		$query = $this->db->get($this->_table);
		return $query->row();
	}

	public function user_by_email($email, $limit = NULL, $start = NULL, $array = false) {
		$this->db->where('email', $email);
		$query = $this->db->get($this->_table, $limit, $start);
		if($array != false) return $query->result_array();
		return $query->result();
	}

	public function users_by_country_code($code, $limit = NULL, $start = NULL) {
		$this->db->where('country_code', $code);
		$query = $this->db->get($this->_table, $limit, $start);
		return $query->result();
	}

	public function users($orderby = 'username', $order = 'ASC', $limit = 50, $start = 0) {
		$orderby = strtolower($orderby);
		$order = strtoupper($order);
		if(!$this->db->field_exists($orderby)) $orderby = 'username';
		if($order != 'DESC') $order = 'ASC';
		$this->db->order_by($orderby, $order);
		$query = $this->db->get($this->_table, $limit, $start);
		return $query->result();
	}

	public function user_exists($username) {
		$this->db->where('username', $username);
		if($this->db->get($this->_table)->num_rows() > 0) return true;
		return false;
	}

	public function create($email, $username, $ingame_name, $password, $register_ip, $country_code, $active) {
		// The username should be validated before.
		// Because of security-reasons it will be checked here as well.
		// Will trigger Error (Exception would show password)
		if($this->user_exists($username)) {
			trigger_error('User with username \'' . htmlentities($username) . '\' already exists.', E_USER_ERROR);
			return false;
		}
		$first_data = array(
			'email' 		=> $email,
			'username' 		=> $username,
			'ingame_name' 	=> $ingame_name,
			'register_ip' 	=> $register_ip,
			'latest_ip'		=> $register_ip,
			'country_code' 	=> $country_code,
			'active' 		=> 0,
			'timestamp'		=> date('Y-m-d H:i:s')
		);

		$this->db->insert($this->_table, $first_data);
		$u = $this->user_by_username($username);
		$fielddata = $this->db->field_data($this->_table);
		$id_maxlen = 11;
		foreach($fielddata[0] as $f) { if($f->name == 'id') { $id_maxlen = $f->max_length; break; }}
		$unique_id = uniqid(str_pad($u->id, $fielddata[0]->max_length, '0'), true);
		$password = $this->hash_password($unique_id, $password);
		$second_data = array(
			'unique_id' => $unique_id,
			'password'	=> $password,
			'active'	=> $active
		);
		$this->db->where('id', $u->id);
		$this->db->update($this->_table, $second_data);
		return true;
	}

	public function check_password($username, $password, $active = TRUE)
	{
		$this->db->where('username', $username);
		$u = $this->db->get($this->_table)->row();
		if($u->active == false && $active == true) return 0;
		if($u->password == $this->hash_password($u->unique_id, $password))
		{
			return true;
		}
		return false;
	}

	public function hash_password($salt, $password) {
		$hashes = hash_algos();
		$alogs = array();
		$return = $password;
		foreach($this->_hash_algos as $h) {
			if(in_array(strtolower($h), $hashes)) {
				$return = hash($h, $salt . $return);
			}
		}
		return $return;
	}
	
	public function max_username_length() {
		$fielddata = $this->db->field_data($this->_table);
		foreach($fielddata as $f) { if($f->name == 'username') { $return = $f->max_length; break; }}
		return (int) $return;
	}

}