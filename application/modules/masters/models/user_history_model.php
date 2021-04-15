<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *Address_model
 *
 * This model represents  user history. It operates the following tables:
 * - user_history,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class User_history_model extends CI_Model{

    private $table_name	= 'user_history';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all users hitory
	 *
	 * @return	array
	 */ 
	function get_all_users_history()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get user history by id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_history_by_user_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	/**
	 * Get user history by id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_history_by_user_id_and_type($user_id,$type)
	{
		
		$this->db->where('user_id', $user_id);
		
		$this->db->where('type', $type);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	/**
	 * Insert new user history
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_history($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
		
			$address_id = $this->db->insert_id();
			
			return $address_id;
		}
		return false;
	}
	
	/**
	 * Update address details by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_history_by_user_id($user_id,$type, $data)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->where('type', $type);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete history by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_history_by_user_id($user_id,$type)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->where('type', $type);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	
	
}