<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Emergency_contacts_model
 *
 * This model represents Emergency contacts. It operates the following tables:
 * - Emergency contacts,
 *
 * @package	Payroll
 * @author	Vathsala
 */ 
 
class Emergency_contacts_model extends CI_Model{

    private $table_name	= 'emergency_contacts';	

	function __construct()
	{
		parent::__construct();
 
	} 
	
	/**
	 * Get all user emergency_contacts
	 *
	 * @return	array
	 */ 
	function get_all_users_emergency_contacts()
	{
		
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
		
			return $query->result_array();
			
		}
		return false;
	}
	
	/**
	 * Get user emergency_contacts by id (user id)
	 *
	 * @param	int
	 * @return	array
	 */
	function get_user_emergency_contacts_by_id($user_id)
	{
		
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get($this->table_name);
		
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}

	
	/**
	 * Insert new user emergency_contacts
	 *
	 * @param	array
	 * @param	bool
	 * @return	id
	 */
	function insert_emergency_contacts($data)
	{
		
			
			if ($this->db->insert($this->table_name, $data)) {
			
				$edu_id = $this->db->insert_id();
				
				return $edu_id;
			}
			return false;
		
	}
	
	/**
	 * Update user emergency_contacts by user id
	 *
	 * @param	array
	 * @param	int
	 * @return	bool
	 */
	function update_user_emergency_contacts($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		
		if ($this->db->update($this->table_name, $data)) {
			
			return true;
		}
		return false;
	}
	
	/**
	 * Delete user emergency_contacts by user id
	 *
	 * @param	int
	 * @return	bool
	 */
	function delete_user_emergency_contacts($user_id)
	{
		$this->db->where('user_id', $user_id);
		
		$this->db->delete($this->table_name);
		
		if ($this->db->affected_rows() > 0) {
		
			return true;
			
		}
		return false;
	}
	
}